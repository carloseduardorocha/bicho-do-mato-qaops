<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Get all users.
     */
    public function getAll(): array
    {
        return User::query()
            ->orderBy(User::ID, 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get user by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): array
    {
        return User::query()
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * Get users paginated.
     */
    public function getPaginated(int $per_page = 15): LengthAwarePaginator
    {
        return User::query()
            ->orderBy(User::ID, 'desc')
            ->paginate($per_page);
    }

    /**
     * Create a user.
     */
    public function create(array $data): array
    {
        try {
            $user = User::query()->create([
                User::NAME => $data[User::NAME] ?? null,
                User::EMAIL => $data[User::EMAIL] ?? null,
                User::PASSWORD => isset($data[User::PASSWORD]) ? Hash::make($data[User::PASSWORD]) : null,
            ]);

            return $user->toArray();

        } catch (\Throwable $e) {
            Log::error('UserService@create failed', [
                'data' => Arr::except($data, User::PASSWORD),
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update user.
     */
    public function update(int $id, array $data): array
    {
        try {
            $user = User::query()->findOrFail($id);

            $updateData = [
                User::NAME => $data[User::NAME] ?? $user->{User::NAME},
                User::EMAIL => $data[User::EMAIL] ?? $user->{User::EMAIL},
            ];

            // Só atualiza a senha se foi fornecida
            if (isset($data[User::PASSWORD]) && ! empty($data[User::PASSWORD])) {
                $updateData[User::PASSWORD] = Hash::make($data[User::PASSWORD]);
            }

            $user->update($updateData);

            return $user->refresh()->toArray();

        } catch (\Throwable $e) {
            Log::error('UserService@update failed', [
                'id' => $id,
                'data' => Arr::except($data, User::PASSWORD),
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Delete user.
     */
    public function delete(int $id): bool
    {
        try {
            $user = User::query()->findOrFail($id);

            return (bool) $user->delete();

        } catch (\Throwable $e) {
            Log::error('UserService@delete failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Check if email already exists (excluding a specific user ID).
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = User::query()->where(User::EMAIL, $email);

        if ($excludeId) {
            $query->where(User::ID, '!=', $excludeId);
        }

        return $query->exists();
    }
}
