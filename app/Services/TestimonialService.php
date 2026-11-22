<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestimonialService
{
    /**
     * Get all testimonials (admin may want this).
     */
    public function getAll(): array
    {
        return Testimonial::query()
            ->orderBy(Testimonial::ID, 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get testimonial by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): array
    {
        return Testimonial::query()
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * Get paginated testimonials (only approved).
     */
    public function getPaginated(int $per_page = 15): LengthAwarePaginator
    {
        return Testimonial::query()
            ->where(Testimonial::IS_APPROVED, true)
            ->orderBy(Testimonial::ID, 'desc')
            ->paginate($per_page);
    }

    /**
     * Create a new testimonial.
     */
    public function create(array $data): array
    {
        try {
            $testimonial = Testimonial::query()->create([
                Testimonial::NAME => $data[Testimonial::NAME] ?? null,
                Testimonial::DESCRIPTION => $data[Testimonial::DESCRIPTION] ?? null,
                Testimonial::IMAGE => $data[Testimonial::IMAGE] ?? null,
                Testimonial::IS_APPROVED => false,
            ]);

            return $testimonial->toArray();

        } catch (\Throwable $e) {
            // Se falhar, deleta a imagem que foi enviada
            if (isset($data[Testimonial::IMAGE])) {
                $this->deleteImage($data[Testimonial::IMAGE]);
            }

            Log::error('TestimonialService@create failed', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update an existing testimonial.
     */
    public function update(int $id, array $data): array
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($id);
            $oldImage = $testimonial->{Testimonial::IMAGE};

            // Atualiza os dados
            $testimonial->update([
                Testimonial::NAME => $data[Testimonial::NAME] ?? $testimonial->{Testimonial::NAME},
                Testimonial::DESCRIPTION => $data[Testimonial::DESCRIPTION] ?? $testimonial->{Testimonial::DESCRIPTION},
                Testimonial::IMAGE => $data[Testimonial::IMAGE] ?? $testimonial->{Testimonial::IMAGE},
                Testimonial::IS_APPROVED => $data[Testimonial::IS_APPROVED] ?? $testimonial->{Testimonial::IS_APPROVED},
            ]);

            // Se uma nova imagem foi enviada, deleta a antiga
            if (isset($data[Testimonial::IMAGE]) && $oldImage && $oldImage !== $data[Testimonial::IMAGE]) {
                $this->deleteImage($oldImage);
            }

            return $testimonial->refresh()->toArray();

        } catch (\Throwable $e) {
            // Se falhar e uma nova imagem foi enviada, deleta ela
            if (isset($data[Testimonial::IMAGE])) {
                $this->deleteImage($data[Testimonial::IMAGE]);
            }

            Log::error('TestimonialService@update failed', [
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Approve testimonial.
     */
    public function approve(int $id): array
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($id);

            $testimonial->update([
                Testimonial::IS_APPROVED => true,
            ]);

            return $testimonial->refresh()->toArray();

        } catch (\Throwable $e) {
            Log::error('TestimonialService@approve failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Reject testimonial (soft delete + delete image)
     */
    public function reject(int $id): bool
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($id);
            $imagePath = $testimonial->{Testimonial::IMAGE};

            // Marca como não aprovado
            $testimonial->update([
                Testimonial::IS_APPROVED => false,
            ]);

            // Soft delete
            $deleted = (bool) $testimonial->delete();

            // Deleta a imagem se existir
            if ($deleted && $imagePath) {
                $this->deleteImage($imagePath);
            }

            return $deleted;

        } catch (\Throwable $e) {
            Log::error('TestimonialService@reject failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Get testimonials pending approval.
     */
    public function getPending(int $per_page = 15): LengthAwarePaginator
    {
        return Testimonial::query()
            ->where(Testimonial::IS_APPROVED, false)
            ->orderBy(Testimonial::ID, 'desc')
            ->paginate($per_page);
    }

    /**
     * Soft delete a testimonial.
     */
    public function delete(int $id): bool
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($id);
            $imagePath = $testimonial->{Testimonial::IMAGE};

            // Soft delete
            $deleted = (bool) $testimonial->delete();

            // Deleta a imagem se existir
            if ($deleted && $imagePath) {
                $this->deleteImage($imagePath);
            }

            return $deleted;

        } catch (\Throwable $e) {
            Log::error('TestimonialService@delete failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Delete image from storage.
     */
    private function deleteImage(string $imagePath): bool
    {
        try {
            if (Storage::disk('public')->exists($imagePath)) {
                return Storage::disk('public')->delete($imagePath);
            }

            return false;
        } catch (\Throwable $e) {
            Log::warning('Failed to delete testimonial image', [
                'path' => $imagePath,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * OPCIONAL: Limpar imagens de depoimentos deletados (soft deleted)
     * Pode ser chamado por um comando Artisan ou scheduled job
     */
    public function cleanupDeletedTestimonialsImages(): int
    {
        try {
            $deletedTestimonials = Testimonial::onlyTrashed()->get();
            $count = 0;

            foreach ($deletedTestimonials as $testimonial) {
                if ($testimonial->{Testimonial::IMAGE}) {
                    if ($this->deleteImage($testimonial->{Testimonial::IMAGE})) {
                        $count++;
                    }

                    // Limpa referência da imagem
                    $testimonial->{Testimonial::IMAGE} = null;
                    $testimonial->save();
                }
            }

            Log::info('Cleaned up deleted testimonials images', ['count' => $count]);

            return $count;

        } catch (\Throwable $e) {
            Log::error('TestimonialService@cleanupDeletedTestimonialsImages failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
