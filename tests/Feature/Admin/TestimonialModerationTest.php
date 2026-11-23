<?php

namespace Tests\Feature\Admin;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesUploads;
use Tests\TestCase;

/**
 * R1: only the moderation in the admin makes a testimonial public.
 */
class TestimonialModerationTest extends TestCase
{
    use CreatesUploads, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_testimonial_sent_by_the_public_appears_only_after_approval(): void
    {
        $this->post('/depoimentos', ['nome' => 'Ana', 'descricao' => 'Adotei um gato', 'foto' => $this->pngUpload()]);
        $testimonial = Testimonial::query()->sole();

        $this->get('/depoimentos')->assertDontSee('Adotei um gato');
        $this->get('/admin/testimonials/moderate')->assertOk()->assertSee('Adotei um gato');

        $this->post("/admin/testimonials/{$testimonial->id}/approve")
            ->assertRedirect(route('admin.testimonials.moderate'))
            ->assertSessionHas('success');

        $this->get('/depoimentos')->assertSee('Adotei um gato');
        $this->get('/admin/testimonials/moderate')->assertDontSee('Adotei um gato');
    }

    public function test_rejected_testimonial_leaves_the_queue_and_never_becomes_public(): void
    {
        Storage::disk('public')->put('testimonials/a.png', 'x');
        $testimonial = Testimonial::factory()->create(['description' => 'Spam enviado', 'image' => 'testimonials/a.png']);

        $this->post("/admin/testimonials/{$testimonial->id}/reject")
            ->assertRedirect(route('admin.testimonials.moderate'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($testimonial);
        Storage::disk('public')->assertMissing('testimonials/a.png');
        $this->get('/depoimentos')->assertDontSee('Spam enviado');
        $this->get('/admin/testimonials/moderate')->assertDontSee('Spam enviado');
    }

    public function test_approving_a_missing_testimonial_reports_an_error(): void
    {
        $this->post('/admin/testimonials/999/approve')->assertRedirect()->assertSessionHas('error');
    }

    public function test_rejecting_a_missing_testimonial_reports_an_error(): void
    {
        $this->post('/admin/testimonials/999/reject')->assertRedirect()->assertSessionHas('error');
    }

    public function test_admin_list_shows_only_approved_testimonials(): void
    {
        Testimonial::factory()->approved()->create(['name' => 'Ana Aprovada']);
        Testimonial::factory()->create(['name' => 'Pedro Pendente']);

        $this->get('/admin/testimonials')->assertOk()->assertSee('Ana Aprovada')->assertDontSee('Pedro Pendente');
    }

    public function test_testimonial_created_in_the_admin_also_starts_as_pending(): void
    {
        $this->post('/admin/testimonials', ['name' => 'Ana', 'description' => 'Texto', 'is_approved' => 1])
            ->assertRedirect(route('admin.testimonials.index'));

        $this->assertDatabaseHas('testimonials', ['name' => 'Ana', 'is_approved' => false]);
    }

    public function test_editing_a_pending_testimonial_does_not_approve_it(): void
    {
        $testimonial = Testimonial::factory()->create();

        $this->put("/admin/testimonials/{$testimonial->id}", [
            'name' => 'Ana',
            'description' => 'Texto editado',
            'is_approved' => 1,
        ])->assertRedirect(route('admin.testimonials.index'));

        $this->assertDatabaseHas('testimonials', ['description' => 'Texto editado', 'is_approved' => false]);
    }

    public function test_deleted_testimonial_disappears_from_the_site(): void
    {
        $testimonial = Testimonial::factory()->approved()->create(['name' => 'Ana Aprovada']);

        $this->delete("/admin/testimonials/{$testimonial->id}")->assertRedirect(route('admin.testimonials.index'));

        $this->assertSoftDeleted($testimonial);
        $this->get('/depoimentos')->assertDontSee('Ana Aprovada');
    }

    public function test_pending_route_lists_testimonials_waiting_for_moderation(): void
    {
        $this->get('/admin/testimonials/pending')->assertOk();
    }
}
