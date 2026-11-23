<?php

namespace Tests\Feature\Public;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\CreatesUploads;
use Tests\TestCase;

/**
 * R3: an invalid public submission must not be accepted.
 */
class TestimonialSubmissionTest extends TestCase
{
    use CreatesUploads, RefreshDatabase;

    private const MAX_IMAGE_BYTES = 2048 * 1024;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'nome' => 'Ana',
            'descricao' => 'Adotei um gato',
            'foto' => $this->pngUpload(),
        ], $overrides);
    }

    /** @param array<string, mixed> $data */
    private function assertSubmissionIsRefused(array $data, string $field): void
    {
        $this->from('/depoimentos')
            ->post('/depoimentos', $data)
            ->assertRedirect('/depoimentos')
            ->assertSessionHasErrors([$field]);

        $this->assertDatabaseCount('testimonials', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_valid_submission_is_saved_as_pending_with_its_image(): void
    {
        $this->from('/depoimentos')
            ->post('/depoimentos', $this->validData())
            ->assertRedirect('/depoimentos')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $testimonial = Testimonial::query()->sole();
        $this->assertSame('Ana', $testimonial->name);
        $this->assertSame('Adotei um gato', $testimonial->description);
        $this->assertFalse((bool) $testimonial->is_approved);
        $this->assertStringStartsWith('testimonials/', $testimonial->image);
        Storage::disk('public')->assertExists($testimonial->image);
    }

    public function test_visitor_can_not_approve_their_own_testimonial_in_the_submission(): void
    {
        $this->post('/depoimentos', $this->validData(['is_approved' => 1]));

        $this->assertFalse((bool) Testimonial::query()->sole()->is_approved);
    }

    /** @return array<string, array{string, mixed}> */
    public static function invalidFields(): array
    {
        return [
            'missing name' => ['nome', null],
            'blank name' => ['nome', '   '],
            'name that is not text' => ['nome', ['Ana']],
            'name over 100 characters' => ['nome', str_repeat('a', 101)],
            'missing text' => ['descricao', null],
            'blank text' => ['descricao', '   '],
            'text over 500 characters' => ['descricao', str_repeat('a', 501)],
            'missing photo' => ['foto', null],
            'photo sent as text' => ['foto', 'photo.png'],
        ];
    }

    #[DataProvider('invalidFields')]
    public function test_submission_with_invalid_field_is_refused(string $field, mixed $value): void
    {
        $this->assertSubmissionIsRefused($this->validData([$field => $value]), $field);
    }

    public function test_name_and_text_at_the_maximum_length_are_accepted(): void
    {
        $this->post('/depoimentos', $this->validData([
            'nome' => str_repeat('a', 100),
            'descricao' => str_repeat('a', 500),
        ]))->assertSessionHasNoErrors();

        $this->assertDatabaseCount('testimonials', 1);
    }

    public function test_file_that_is_not_an_image_is_refused(): void
    {
        $pdf = $this->upload('document.pdf', "%PDF-1.4\n%%EOF");

        $this->assertSubmissionIsRefused($this->validData(['foto' => $pdf]), 'foto');
    }

    public function test_script_disguised_with_an_image_extension_is_refused(): void
    {
        $script = $this->upload('photo.jpg', '<?php echo "x";');

        $this->assertSubmissionIsRefused($this->validData(['foto' => $script]), 'foto');
    }

    public function test_svg_image_is_refused(): void
    {
        $svg = $this->upload('photo.svg', '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>');

        $this->assertSubmissionIsRefused($this->validData(['foto' => $svg]), 'foto');
    }

    public function test_image_over_two_megabytes_is_refused(): void
    {
        $image = $this->pngUpload(bytes: self::MAX_IMAGE_BYTES + 1);

        $this->assertSubmissionIsRefused($this->validData(['foto' => $image]), 'foto');
    }

    public function test_image_of_exactly_two_megabytes_is_accepted(): void
    {
        $this->post('/depoimentos', $this->validData(['foto' => $this->pngUpload(bytes: self::MAX_IMAGE_BYTES)]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('testimonials', 1);
    }

    public function test_failure_while_saving_reports_an_error_and_leaves_no_orphan_image(): void
    {
        Testimonial::creating(fn () => throw new \RuntimeException('database down'));

        $this->from('/depoimentos')
            ->post('/depoimentos', $this->validData())
            ->assertRedirect('/depoimentos')
            ->assertSessionHas('error');

        $this->assertDatabaseCount('testimonials', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }
}
