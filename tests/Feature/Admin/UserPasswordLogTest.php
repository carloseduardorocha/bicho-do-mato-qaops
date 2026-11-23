<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * A failure while saving a user must not write the password to the log.
 */
class UserPasswordLogTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'senha-super-secreta';

    private const DATA = [
        'name' => 'Conta Nova',
        'email' => 'nova@example.com',
        'password' => self::PASSWORD,
        'password_confirmation' => self::PASSWORD,
    ];

    /** @var list<string> */
    private array $logged = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        Event::listen(function (MessageLogged $event) {
            $this->logged[] = $event->message.json_encode($event->context);
        });
    }

    private function assertFailureWasLoggedWithoutThePassword(): void
    {
        // One entry from the service and one from the controller.
        $this->assertCount(2, $this->logged);
        $this->assertStringNotContainsString(self::PASSWORD, implode("\n", $this->logged));
    }

    public function test_failure_while_creating_a_user_does_not_log_the_password(): void
    {
        User::creating(fn () => throw new \RuntimeException('database down'));

        $this->post('/admin/users', self::DATA)->assertSessionHas('error');

        $this->assertFailureWasLoggedWithoutThePassword();
    }

    public function test_failure_while_updating_a_user_does_not_log_the_password(): void
    {
        $user = User::factory()->create();
        User::updating(fn () => throw new \RuntimeException('database down'));

        $this->put("/admin/users/{$user->id}", self::DATA)->assertSessionHas('error');

        $this->assertFailureWasLoggedWithoutThePassword();
    }
}
