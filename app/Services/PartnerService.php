<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PartnerService
{
    /**
     * Get all partners.
     */
    public function getAll(): array
    {
        return Partner::query()
            ->orderBy(Partner::NAME)
            ->get()
            ->toArray();
    }

    /**
     * Get partner by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): array
    {
        return Partner::query()
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * Get all partners paginated.
     */
    public function getPaginated(int $per_page = 15): LengthAwarePaginator
    {
        return Partner::query()
            ->orderBy(Partner::ID, 'desc')
            ->paginate($per_page);
    }

    /**
     * Create a new partner.
     */
    public function create(array $data): array
    {
        try {
            $partner = Partner::query()->create([
                Partner::NAME => $data[Partner::NAME] ?? null,
                Partner::IMAGE => $data[Partner::IMAGE] ?? null,
                Partner::LINK => $data[Partner::LINK] ?? null,
            ]);

            return $partner->toArray();

        } catch (\Throwable $e) {
            // Se falhar, deleta a imagem que foi enviada
            if (isset($data[Partner::IMAGE])) {
                $this->deleteImage($data[Partner::IMAGE]);
            }

            Log::error('PartnerService@create failed', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update a partner by ID.
     */
    public function update(int $id, array $data): array
    {
        try {
            $partner = Partner::query()->findOrFail($id);
            $oldImage = $partner->{Partner::IMAGE};

            // Atualiza os dados
            $partner->update([
                Partner::NAME => $data[Partner::NAME] ?? $partner->{Partner::NAME},
                Partner::IMAGE => $data[Partner::IMAGE] ?? $partner->{Partner::IMAGE},
                Partner::LINK => $data[Partner::LINK] ?? $partner->{Partner::LINK},
            ]);

            // Se uma nova imagem foi enviada, deleta a antiga
            if (isset($data[Partner::IMAGE]) && $oldImage && $oldImage !== $data[Partner::IMAGE]) {
                $this->deleteImage($oldImage);
            }

            return $partner->refresh()->toArray();

        } catch (\Throwable $e) {
            // Se falhar e uma nova imagem foi enviada, deleta ela
            if (isset($data[Partner::IMAGE])) {
                $this->deleteImage($data[Partner::IMAGE]);
            }

            Log::error('PartnerService@update failed', [
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Soft delete a partner.
     */
    public function delete(int $id): bool
    {
        try {
            $partner = Partner::query()->findOrFail($id);

            return (bool) $partner->delete();

        } catch (\Throwable $e) {
            Log::error('PartnerService@delete failed', [
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
            Log::warning('Failed to delete image', [
                'path' => $imagePath,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * OPCIONAL: Limpar imagens de parceiros deletados (soft deleted)
     * Pode ser chamado por um comando Artisan ou scheduled job
     */
    public function cleanupDeletedPartnersImages(): int
    {
        try {
            $deletedPartners = Partner::onlyTrashed()->get();
            $count = 0;

            foreach ($deletedPartners as $partner) {
                if ($partner->{Partner::IMAGE}) {
                    if ($this->deleteImage($partner->{Partner::IMAGE})) {
                        $count++;
                    }
                }
            }

            Log::info('Cleaned up deleted partners images', ['count' => $count]);

            return $count;

        } catch (\Throwable $e) {
            Log::error('PartnerService@cleanupDeletedPartnersImages failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
