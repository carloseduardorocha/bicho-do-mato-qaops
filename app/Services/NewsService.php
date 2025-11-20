<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsService
{
    /**
     * Get all news.
     */
    public function getAll(): array
    {
        return News::query()
            ->orderBy(News::ID, 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get news by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): array
    {
        return News::query()
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * Get news paginated.
     */
    public function getPaginated(int $per_page = 15): LengthAwarePaginator
    {
        return News::query()
            ->orderBy(News::ID, 'desc')
            ->paginate($per_page);
    }

    /**
     * Create a news entry.
     */
    public function create(array $data): array
    {
        try {
            $news = News::query()->create([
                News::TITLE       => $data[News::TITLE]       ?? null,
                News::DESCRIPTION => $data[News::DESCRIPTION] ?? null,
                News::AUTHOR_ID   => $data[News::AUTHOR_ID]   ?? null,
                News::IMAGES      => $data[News::IMAGES]      ?? null,
            ]);

            return $news->toArray();

        } catch (\Throwable $e) {
            // Se falhar, deleta as imagens que foram enviadas
            if (isset($data[News::IMAGES])) {
                $this->deleteMultipleImages($data[News::IMAGES]);
            }

            Log::error('NewsService@create failed', [
                'data'  => $data,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Update news entry.
     */
    public function update(int $id, array $data): array
    {
        try {
            $news = News::query()->findOrFail($id);

            $news->update([
                News::TITLE       => $data[News::TITLE]       ?? $news->{News::TITLE},
                News::DESCRIPTION => $data[News::DESCRIPTION] ?? $news->{News::DESCRIPTION},
                News::AUTHOR_ID   => $data[News::AUTHOR_ID]   ?? $news->{News::AUTHOR_ID},
                News::IMAGES      => $data[News::IMAGES]      ?? $news->{News::IMAGES},
            ]);

            return $news->refresh()->toArray();

        } catch (\Throwable $e) {
            // Se falhar e novas imagens foram enviadas, deleta elas
            if (isset($data[News::IMAGES])) {
                $this->deleteMultipleImages($data[News::IMAGES]);
            }

            Log::error('NewsService@update failed', [
                'id'    => $id,
                'data'  => $data,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Soft delete.
     */
    public function delete(int $id): bool
    {
        try {
            $news = News::query()->findOrFail($id);
            $imagesJson = $news->{News::IMAGES};

            // Soft delete
            $deleted = (bool) $news->delete();

            // Deleta as imagens se existirem
            if ($deleted && $imagesJson) {
                $this->deleteMultipleImages($imagesJson);
            }

            return $deleted;

        } catch (\Throwable $e) {
            Log::error('NewsService@delete failed', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Delete a single image from news.
     */
    public function deleteImageFromNews(int $id, string $imagePath): bool
    {
        try {
            $news = News::query()->findOrFail($id);

            // Decodificar array de imagens
            $images = !empty($news->{News::IMAGES}) ? json_decode($news->{News::IMAGES}, true) : [];

            // Remover a imagem do array
            $updatedImages = array_filter($images, function ($path) use ($imagePath) {
                return $path !== $imagePath;
            });

            // Deletar arquivo físico do storage
            $this->deleteImage($imagePath);

            // Atualizar registro
            $news->update([
                News::IMAGES => !empty($updatedImages) ? json_encode(array_values($updatedImages)) : null,
            ]);

            return true;

        } catch (\Throwable $e) {
            Log::error('NewsService@deleteImageFromNews failed', [
                'id'         => $id,
                'image_path' => $imagePath,
                'error'      => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Delete a single image from storage.
     *
     * @param string $imagePath
     * @return bool
     */
    private function deleteImage(string $imagePath): bool
    {
        try {
            if (Storage::disk('public')->exists($imagePath)) {
                return Storage::disk('public')->delete($imagePath);
            }
            return false;
        } catch (\Throwable $e) {
            Log::warning('Failed to delete news image', [
                'path' => $imagePath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete multiple images from storage (JSON string or array).
     *
     * @param string|array $imagesData
     * @return int Number of images deleted
     */
    private function deleteMultipleImages(string|array $imagesData): int
    {
        try {
            // Se vier como string JSON, decodifica
            $images = is_string($imagesData) ? json_decode($imagesData, true) : $imagesData;
            
            if (empty($images) || !is_array($images)) {
                return 0;
            }

            $count = 0;
            foreach ($images as $imagePath) {
                if ($this->deleteImage($imagePath)) {
                    $count++;
                }
            }

            return $count;

        } catch (\Throwable $e) {
            Log::warning('Failed to delete multiple news images', [
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * OPCIONAL: Limpar imagens de notícias deletadas (soft deleted)
     * Pode ser chamado por um comando Artisan ou scheduled job
     */
    public function cleanupDeletedNewsImages(): int
    {
        try {
            $deletedNews = News::onlyTrashed()->get();
            $count = 0;

            foreach ($deletedNews as $news) {
                if ($news->{News::IMAGES}) {
                    $count += $this->deleteMultipleImages($news->{News::IMAGES});

                    // Limpa referência das imagens
                    $news->{News::IMAGES} = null;
                    $news->save();
                }
            }

            Log::info('Cleaned up deleted news images', ['count' => $count]);
            return $count;

        } catch (\Throwable $e) {
            Log::error('NewsService@cleanupDeletedNewsImages failed', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}