<?php

namespace Tests\Feature\Public;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * R1: a testimonial that was not approved must not reach the public site.
 */
class TestimonialVisibilityTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string}> */
    public static function publicPages(): array
    {
        return [
            'testimonials page' => ['/depoimentos'],
            'home page' => ['/'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_page_shows_approved_testimonials(string $url): void
    {
        Testimonial::factory()->approved()->create(['name' => 'Ana Aprovada', 'description' => 'Texto aprovado']);

        $this->get($url)->assertOk()->assertSee('Ana Aprovada')->assertSee('Texto aprovado');
    }

    #[DataProvider('publicPages')]
    public function test_public_page_hides_pending_testimonials(string $url): void
    {
        Testimonial::factory()->create(['name' => 'Pedro Pendente', 'description' => 'Texto pendente']);

        $this->get($url)->assertOk()->assertDontSee('Pedro Pendente')->assertDontSee('Texto pendente');
    }

    #[DataProvider('publicPages')]
    public function test_public_page_hides_deleted_testimonials_that_were_approved(string $url): void
    {
        Testimonial::factory()->approved()->create(['name' => 'Davi Deletado'])->delete();

        $this->get($url)->assertOk()->assertDontSee('Davi Deletado');
    }

    public function test_testimonials_page_shows_twelve_per_page(): void
    {
        Testimonial::factory()->approved()->count(13)->create();

        $this->assertCount(12, $this->get('/depoimentos')->assertOk()->viewData('testimonials'));
        $this->assertCount(1, $this->get('/depoimentos?page=2')->assertOk()->viewData('testimonials'));
    }
}
