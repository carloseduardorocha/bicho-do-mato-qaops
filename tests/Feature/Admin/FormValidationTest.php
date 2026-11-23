<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * The admin forms must show which field is wrong (regression of BUG-4).
 */
class FormValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string, class-string, string}> */
    public static function forms(): array
    {
        return [
            'news' => ['news', News::class, 'title'],
            'partners' => ['partners', Partner::class, 'name'],
            'testimonials' => ['testimonials', Testimonial::class, 'name'],
            'users' => ['users', User::class, 'name'],
        ];
    }

    #[DataProvider('forms')]
    public function test_create_form_receives_the_field_error(string $group, string $model, string $field): void
    {
        $this->actingAs(User::factory()->create())
            ->from("/admin/{$group}/create")
            ->post("/admin/{$group}", [])
            ->assertRedirect("/admin/{$group}/create")
            ->assertSessionHasErrors([$field]);
    }

    #[DataProvider('forms')]
    public function test_edit_form_receives_the_field_error(string $group, string $model, string $field): void
    {
        $record = $model::factory()->create();

        $this->actingAs(User::factory()->create())
            ->from("/admin/{$group}/{$record->id}/edit")
            ->put("/admin/{$group}/{$record->id}", [])
            ->assertRedirect("/admin/{$group}/{$record->id}/edit")
            ->assertSessionHasErrors([$field]);
    }
}
