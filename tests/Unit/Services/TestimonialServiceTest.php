<?php

namespace Tests\Unit\Services;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * R1: a testimonial that was not approved must not reach the public site.
 */
class TestimonialServiceTest extends TestCase
{
    use RefreshDatabase;

    private TestimonialService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->service = new TestimonialService;
    }

    public function test_paginated_list_returns_only_approved_testimonials_newest_first(): void
    {
        $older = Testimonial::factory()->approved()->create();
        Testimonial::factory()->create();
        $newer = Testimonial::factory()->approved()->create();

        $ids = $this->service->getPaginated()->pluck('id')->all();

        $this->assertSame([$newer->id, $older->id], $ids);
    }

    public function test_paginated_list_excludes_approved_testimonials_that_were_deleted(): void
    {
        Testimonial::factory()->approved()->create()->delete();

        $this->assertCount(0, $this->service->getPaginated());
    }

    public function test_paginated_list_respects_the_page_size_and_counts_only_approved(): void
    {
        Testimonial::factory()->approved()->count(3)->create();
        Testimonial::factory()->count(2)->create();

        $page = $this->service->getPaginated(2);

        $this->assertCount(2, $page);
        $this->assertSame(3, $page->total());
    }

    public function test_pending_list_returns_only_testimonials_waiting_for_moderation(): void
    {
        Testimonial::factory()->approved()->create();
        $pending = Testimonial::factory()->create();

        $this->assertSame([$pending->id], $this->service->getPending()->pluck('id')->all());
    }

    public function test_get_all_returns_approved_and_pending_testimonials_newest_first(): void
    {
        $approved = Testimonial::factory()->approved()->create();
        $pending = Testimonial::factory()->create();

        $this->assertSame([$pending->id, $approved->id], array_column($this->service->getAll(), 'id'));
    }

    public function test_get_by_id_returns_the_testimonial(): void
    {
        $testimonial = Testimonial::factory()->create(['name' => 'Ana']);

        $this->assertSame('Ana', $this->service->getById($testimonial->id)['name']);
    }

    public function test_get_by_id_fails_for_a_missing_testimonial(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->getById(999);
    }

    public function test_create_always_starts_as_pending_even_if_approval_is_requested(): void
    {
        $created = $this->service->create([
            'name' => 'Ana',
            'description' => 'Ótimo trabalho',
            'is_approved' => true,
        ]);

        $this->assertDatabaseHas('testimonials', ['id' => $created['id'], 'name' => 'Ana', 'is_approved' => false]);
    }

    public function test_create_removes_the_uploaded_image_when_saving_fails(): void
    {
        Storage::disk('public')->put('testimonials/new.png', 'x');

        try {
            $this->service->create(['name' => null, 'description' => 'x', 'image' => 'testimonials/new.png']);
            $this->fail('A testimonial without a name should not be saved.');
        } catch (QueryException) {
            Storage::disk('public')->assertMissing('testimonials/new.png');
            $this->assertDatabaseCount('testimonials', 0);
        }
    }

    public function test_approve_makes_the_testimonial_public(): void
    {
        $testimonial = Testimonial::factory()->create();

        $this->service->approve($testimonial->id);

        $this->assertSame([$testimonial->id], $this->service->getPaginated()->pluck('id')->all());
        $this->assertCount(0, $this->service->getPending());
    }

    public function test_approve_changes_only_the_chosen_testimonial(): void
    {
        $chosen = Testimonial::factory()->create();
        $other = Testimonial::factory()->create();

        $this->service->approve($chosen->id);

        $this->assertDatabaseHas('testimonials', ['id' => $other->id, 'is_approved' => false]);
    }

    public function test_approve_fails_for_a_missing_testimonial(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->approve(999);
    }

    public function test_a_rejected_testimonial_can_not_be_approved_later(): void
    {
        $testimonial = Testimonial::factory()->create();
        $this->service->reject($testimonial->id);

        $this->expectException(ModelNotFoundException::class);

        $this->service->approve($testimonial->id);
    }

    public function test_reject_unpublishes_soft_deletes_and_removes_the_image(): void
    {
        Storage::disk('public')->put('testimonials/a.png', 'x');
        $testimonial = Testimonial::factory()->approved()->create(['image' => 'testimonials/a.png']);

        $this->assertTrue($this->service->reject($testimonial->id));

        $this->assertSoftDeleted('testimonials', ['id' => $testimonial->id, 'is_approved' => false]);
        Storage::disk('public')->assertMissing('testimonials/a.png');
    }

    public function test_reject_fails_for_a_missing_testimonial(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->reject(999);
    }

    public function test_editing_the_text_keeps_the_testimonial_pending(): void
    {
        $testimonial = Testimonial::factory()->create();

        $this->service->update($testimonial->id, ['description' => 'Texto novo']);

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => $testimonial->name,
            'description' => 'Texto novo',
            'is_approved' => false,
        ]);
    }

    public function test_editing_the_text_keeps_the_testimonial_approved(): void
    {
        $testimonial = Testimonial::factory()->approved()->create();

        $this->service->update($testimonial->id, ['description' => 'Texto novo']);

        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id, 'is_approved' => true]);
    }

    public function test_update_with_a_new_image_removes_the_old_one(): void
    {
        Storage::disk('public')->put('testimonials/old.png', 'x');
        Storage::disk('public')->put('testimonials/new.png', 'x');
        $testimonial = Testimonial::factory()->create(['image' => 'testimonials/old.png']);

        $this->service->update($testimonial->id, ['image' => 'testimonials/new.png']);

        Storage::disk('public')->assertMissing('testimonials/old.png');
        Storage::disk('public')->assertExists('testimonials/new.png');
    }

    public function test_update_of_a_missing_testimonial_removes_the_uploaded_image(): void
    {
        Storage::disk('public')->put('testimonials/new.png', 'x');

        try {
            $this->service->update(999, ['image' => 'testimonials/new.png']);
            $this->fail('Updating a missing testimonial should fail.');
        } catch (ModelNotFoundException) {
            Storage::disk('public')->assertMissing('testimonials/new.png');
        }
    }

    public function test_delete_soft_deletes_and_removes_the_image(): void
    {
        Storage::disk('public')->put('testimonials/a.png', 'x');
        $testimonial = Testimonial::factory()->create(['image' => 'testimonials/a.png']);

        $this->assertTrue($this->service->delete($testimonial->id));

        $this->assertSoftDeleted($testimonial);
        Storage::disk('public')->assertMissing('testimonials/a.png');
    }

    public function test_delete_works_when_the_image_file_is_already_gone(): void
    {
        $testimonial = Testimonial::factory()->create(['image' => 'testimonials/gone.png']);

        $this->assertTrue($this->service->delete($testimonial->id));
    }

    public function test_delete_fails_for_a_missing_testimonial(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->delete(999);
    }

    public function test_cleanup_removes_only_images_of_deleted_testimonials(): void
    {
        Storage::disk('public')->put('testimonials/deleted.png', 'x');
        Storage::disk('public')->put('testimonials/kept.png', 'x');
        $deleted = Testimonial::factory()->create(['image' => 'testimonials/deleted.png']);
        $deleted->delete();
        Testimonial::factory()->create(['image' => 'testimonials/kept.png']);

        $this->assertSame(1, $this->service->cleanupDeletedTestimonialsImages());

        Storage::disk('public')->assertMissing('testimonials/deleted.png');
        Storage::disk('public')->assertExists('testimonials/kept.png');
        $this->assertDatabaseHas('testimonials', ['id' => $deleted->id, 'image' => null]);
    }
}
