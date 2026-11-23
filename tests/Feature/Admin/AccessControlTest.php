<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as Router;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * R2: a visitor without login must not use the admin nor create an account.
 */
class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string}> */
    public static function adminGroups(): array
    {
        return [
            'dashboard' => ['dashboard'],
            'partners' => ['partners'],
            'testimonials' => ['testimonials'],
            'news' => ['news'],
            'users' => ['users'],
        ];
    }

    /** @return list<Route> */
    private function routesUnder(string $prefix): array
    {
        return collect(Router::getRoutes()->getRoutes())
            ->filter(fn (Route $route) => str_starts_with($route->uri().'/', $prefix.'/'))
            ->values()
            ->all();
    }

    #[DataProvider('adminGroups')]
    public function test_guest_is_redirected_to_the_home_page_on_every_route_of_the_group(string $group): void
    {
        $routes = $this->routesUnder("admin/{$group}");
        $this->assertNotEmpty($routes);

        foreach ($routes as $route) {
            $response = $this->call($route->methods()[0], '/'.str_replace('{id}', '1', $route->uri()));

            $this->assertTrue(
                $response->isRedirect(route('public.home')),
                "{$route->methods()[0]} {$route->uri()} should redirect a guest to the home page, got {$response->status()}.",
            );
        }
    }

    public function test_every_admin_route_belongs_to_a_group_checked_for_guests(): void
    {
        $groups = array_unique(array_map(
            fn (Route $route) => explode('/', $route->uri())[1] ?? '',
            $this->routesUnder('admin'),
        ));

        $this->assertEqualsCanonicalizing(array_keys(self::adminGroups()), array_values($groups));
    }

    #[DataProvider('adminGroups')]
    public function test_logged_in_user_can_open_the_group(string $group): void
    {
        $this->actingAs(User::factory()->create())->get("/admin/{$group}")->assertOk();
    }

    public function test_guest_can_not_approve_a_testimonial(): void
    {
        $testimonial = Testimonial::factory()->create();

        $this->post("/admin/testimonials/{$testimonial->id}/approve")->assertRedirect(route('public.home'));

        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id, 'is_approved' => false]);
    }

    public function test_guest_can_not_reject_or_delete_a_testimonial(): void
    {
        $testimonial = Testimonial::factory()->approved()->create();

        $this->post("/admin/testimonials/{$testimonial->id}/reject");
        $this->delete("/admin/testimonials/{$testimonial->id}");

        $this->assertNotSoftDeleted($testimonial);
    }

    public function test_guest_can_not_create_edit_or_delete_news(): void
    {
        $news = News::factory()->create(['title' => 'Original']);

        $this->post('/admin/news', ['title' => 'Invasão', 'description' => 'x']);
        $this->put("/admin/news/{$news->id}", ['title' => 'Invasão', 'description' => 'x']);
        $this->delete("/admin/news/{$news->id}");

        $this->assertDatabaseCount('news', 1);
        $this->assertNotSoftDeleted($news);
        $this->assertSame('Original', $news->refresh()->title);
    }

    public function test_guest_can_not_create_edit_or_delete_partners(): void
    {
        $partner = Partner::factory()->create(['name' => 'Original']);

        $this->post('/admin/partners', ['name' => 'Invasão']);
        $this->put("/admin/partners/{$partner->id}", ['name' => 'Invasão']);
        $this->delete("/admin/partners/{$partner->id}");

        $this->assertDatabaseCount('partners', 1);
        $this->assertNotSoftDeleted($partner);
        $this->assertSame('Original', $partner->refresh()->name);
    }

    public function test_guest_can_not_create_edit_or_delete_users(): void
    {
        $user = User::factory()->create(['name' => 'Original']);

        $this->post('/admin/users', $this->accountData());
        $this->put("/admin/users/{$user->id}", $this->accountData());
        $this->delete("/admin/users/{$user->id}");

        $this->assertDatabaseCount('users', 1);
        $this->assertSame('Original', $user->refresh()->name);
    }

    public function test_public_sign_up_does_not_exist_and_creates_no_account(): void
    {
        $this->post('/register', $this->accountData())->assertNotFound();

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_public_sign_up_page_does_not_exist(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_logged_in_user_can_create_an_account_that_logs_in(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/users', $this->accountData())
            ->assertRedirect(route('admin.users.index'));
        $this->post('/logout');
        $this->assertGuest();

        $this->post('/login', ['email' => 'nova@example.com', 'password' => 'senha-segura']);

        $this->assertAuthenticatedAs(User::query()->where('email', 'nova@example.com')->sole());
    }

    /** @return array<string, string> */
    private function accountData(): array
    {
        return [
            'name' => 'Conta Nova',
            'email' => 'nova@example.com',
            'password' => 'senha-segura',
            'password_confirmation' => 'senha-segura',
        ];
    }
}
