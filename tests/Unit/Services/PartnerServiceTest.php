<?php

namespace Tests\Unit\Services;

use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Partner CRUD must keep the records and the logo files consistent
 * (same rule as R4 for news).
 */
class PartnerServiceTest extends TestCase
{
    use RefreshDatabase;

    private PartnerService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->service = new PartnerService;
    }

    private function partnerWithStoredImage(string $path): Partner
    {
        Storage::disk('public')->put($path, 'x');

        return Partner::factory()->create([Partner::IMAGE => $path]);
    }

    public function test_get_all_returns_partners_by_name_without_the_deleted_ones(): void
    {
        Partner::factory()->create([Partner::NAME => 'Veterinária Bem-Estar']);
        Partner::factory()->create([Partner::NAME => 'Agropecuária Sul']);
        Partner::factory()->create([Partner::NAME => 'Excluído'])->delete();

        $this->assertSame(
            ['Agropecuária Sul', 'Veterinária Bem-Estar'],
            array_column($this->service->getAll(), Partner::NAME),
        );
    }

    public function test_paginated_list_respects_the_page_size_and_is_newest_first(): void
    {
        $partners = Partner::factory()->count(3)->create();

        $page = $this->service->getPaginated(2);

        $this->assertSame([$partners[2]->id, $partners[1]->id], $page->pluck('id')->all());
        $this->assertSame(3, $page->total());
    }

    public function test_get_by_id_returns_the_partner(): void
    {
        $partner = Partner::factory()->create([Partner::NAME => 'Pet Shop Amigo']);

        $this->assertSame('Pet Shop Amigo', $this->service->getById($partner->id)[Partner::NAME]);
    }

    public function test_get_by_id_fails_for_a_deleted_partner(): void
    {
        $partner = Partner::factory()->create();
        $partner->delete();

        $this->expectException(ModelNotFoundException::class);

        $this->service->getById($partner->id);
    }

    public function test_create_saves_the_partner_with_its_logo(): void
    {
        Storage::disk('public')->put('partners/logo.png', 'x');

        $partner = $this->service->create([
            Partner::NAME => 'Clínica Patas',
            Partner::IMAGE => 'partners/logo.png',
            Partner::LINK => 'https://example.com',
        ]);

        $this->assertDatabaseHas('partners', [
            Partner::ID => $partner['id'],
            Partner::NAME => 'Clínica Patas',
            Partner::IMAGE => 'partners/logo.png',
        ]);
        Storage::disk('public')->assertExists('partners/logo.png');
    }

    public function test_create_removes_the_uploaded_logo_when_saving_fails(): void
    {
        Storage::disk('public')->put('partners/logo.png', 'x');

        try {
            $this->service->create([Partner::IMAGE => 'partners/logo.png']);
            $this->fail('A partner without a name should not be saved.');
        } catch (QueryException) {
            Storage::disk('public')->assertMissing('partners/logo.png');
            $this->assertDatabaseCount('partners', 0);
        }
    }

    public function test_update_changes_only_the_given_fields(): void
    {
        $partner = $this->partnerWithStoredImage('partners/logo.png');

        $updated = $this->service->update($partner->id, [Partner::NAME => 'Nome novo']);

        $this->assertSame('Nome novo', $updated[Partner::NAME]);
        $this->assertSame($partner->link, $updated[Partner::LINK]);
        $this->assertSame('partners/logo.png', $updated[Partner::IMAGE]);
        Storage::disk('public')->assertExists('partners/logo.png');
    }

    public function test_update_with_a_new_logo_removes_the_old_one(): void
    {
        $partner = $this->partnerWithStoredImage('partners/old.png');
        Storage::disk('public')->put('partners/new.png', 'x');

        $updated = $this->service->update($partner->id, [Partner::IMAGE => 'partners/new.png']);

        $this->assertSame('partners/new.png', $updated[Partner::IMAGE]);
        Storage::disk('public')->assertMissing('partners/old.png');
        Storage::disk('public')->assertExists('partners/new.png');
    }

    public function test_update_with_the_same_logo_keeps_the_file(): void
    {
        $partner = $this->partnerWithStoredImage('partners/logo.png');

        $this->service->update($partner->id, [Partner::IMAGE => 'partners/logo.png']);

        Storage::disk('public')->assertExists('partners/logo.png');
    }

    public function test_update_of_a_missing_partner_removes_the_uploaded_logo(): void
    {
        Storage::disk('public')->put('partners/new.png', 'x');

        try {
            $this->service->update(999, [Partner::IMAGE => 'partners/new.png']);
            $this->fail('A missing partner should not be updated.');
        } catch (ModelNotFoundException) {
            Storage::disk('public')->assertMissing('partners/new.png');
        }
    }

    public function test_failed_update_keeps_the_logo_the_partner_already_had(): void
    {
        $partner = $this->partnerWithStoredImage('partners/old.png');
        Storage::disk('public')->put('partners/new.png', 'x');
        Partner::updating(fn () => throw new \RuntimeException('database down'));

        try {
            $this->service->update($partner->id, [Partner::IMAGE => 'partners/new.png']);
            $this->fail('The update should have failed.');
        } catch (\RuntimeException) {
            Storage::disk('public')->assertMissing('partners/new.png');
            Storage::disk('public')->assertExists('partners/old.png');
            $this->assertSame('partners/old.png', $partner->fresh()->image);
        }
    }

    public function test_delete_soft_deletes_the_partner(): void
    {
        $partner = Partner::factory()->create();

        $this->assertTrue($this->service->delete($partner->id));

        $this->assertSoftDeleted('partners', [Partner::ID => $partner->id]);
    }

    public function test_delete_fails_for_a_missing_partner(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->delete(999);
    }

    public function test_cleanup_removes_only_logos_of_deleted_partners(): void
    {
        $this->partnerWithStoredImage('partners/deleted.png')->delete();
        $this->partnerWithStoredImage('partners/active.png');
        // Deleted partner whose file is already gone: nothing to remove, not counted.
        Partner::factory()->create([Partner::IMAGE => 'partners/gone.png'])->delete();
        Partner::factory()->create()->delete();

        $this->assertSame(1, $this->service->cleanupDeletedPartnersImages());

        Storage::disk('public')->assertMissing('partners/deleted.png');
        Storage::disk('public')->assertExists('partners/active.png');
    }
}
