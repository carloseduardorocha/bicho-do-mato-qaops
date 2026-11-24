<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Admin accounts (outside R1-R4): passwords are always hashed, an edit without a new
 * password keeps the old one, and e-mails stay unique.
 */
class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new UserService;
    }

    public function test_get_all_returns_users_newest_first_without_the_password(): void
    {
        $older = User::factory()->create();
        $newer = User::factory()->create();

        $users = $this->service->getAll();

        $this->assertSame([$newer->id, $older->id], array_column($users, 'id'));
        $this->assertArrayNotHasKey(User::PASSWORD, $users[0]);
    }

    public function test_paginated_list_respects_the_page_size_and_is_newest_first(): void
    {
        $users = User::factory()->count(3)->create();

        $page = $this->service->getPaginated(2);

        $this->assertSame([$users[2]->id, $users[1]->id], $page->pluck('id')->all());
        $this->assertSame(3, $page->total());
    }

    public function test_get_by_id_returns_the_user(): void
    {
        $user = User::factory()->create([User::NAME => 'Voluntária']);

        $this->assertSame('Voluntária', $this->service->getById($user->id)[User::NAME]);
    }

    public function test_get_by_id_fails_for_a_missing_user(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->getById(999);
    }

    public function test_create_stores_the_password_hashed(): void
    {
        $created = $this->service->create([
            User::NAME => 'Conta Nova',
            User::EMAIL => 'nova@example.com',
            User::PASSWORD => 'senha-de-teste',
        ]);

        $stored = User::query()->findOrFail($created['id'])->password;
        $this->assertNotSame('senha-de-teste', $stored);
        $this->assertTrue(Hash::check('senha-de-teste', $stored));
    }

    public function test_create_with_a_repeated_email_fails(): void
    {
        User::factory()->create([User::EMAIL => 'igual@example.com']);

        $this->expectException(QueryException::class);

        $this->service->create([
            User::NAME => 'Outra',
            User::EMAIL => 'igual@example.com',
            User::PASSWORD => 'senha-de-teste',
        ]);
    }

    public function test_update_with_a_new_password_replaces_it(): void
    {
        $user = User::factory()->create();

        $this->service->update($user->id, [User::PASSWORD => 'senha-nova-456']);

        $this->assertTrue(Hash::check('senha-nova-456', $user->fresh()->password));
    }

    /** @return array<string, array{0: array<string, mixed>}> */
    public static function dataWithoutPassword(): array
    {
        return [
            'no password field' => [[User::NAME => 'Nome novo']],
            'empty password' => [[User::NAME => 'Nome novo', User::PASSWORD => '']],
        ];
    }

    /** @param  array<string, mixed>  $data */
    #[DataProvider('dataWithoutPassword')]
    public function test_update_without_a_password_keeps_the_old_one(array $data): void
    {
        $user = User::factory()->create();
        $oldHash = $user->password;

        $updated = $this->service->update($user->id, $data);

        $this->assertSame('Nome novo', $updated[User::NAME]);
        $this->assertSame($user->email, $updated[User::EMAIL]);
        $this->assertSame($oldHash, $user->fresh()->password);
    }

    public function test_update_fails_for_a_missing_user(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->update(999, [User::NAME => 'Ninguém']);
    }

    public function test_delete_removes_the_user(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($this->service->delete($user->id));

        $this->assertDatabaseMissing('users', [User::ID => $user->id]);
    }

    public function test_delete_fails_for_a_missing_user(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->delete(999);
    }

    public function test_email_exists_can_ignore_the_user_being_edited(): void
    {
        $user = User::factory()->create([User::EMAIL => 'eu@example.com']);

        $this->assertTrue($this->service->emailExists('eu@example.com'));
        $this->assertFalse($this->service->emailExists('eu@example.com', $user->id));
        $this->assertFalse($this->service->emailExists('outro@example.com'));
    }
}
