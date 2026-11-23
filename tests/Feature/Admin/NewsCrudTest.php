<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\CreatesUploads;
use Tests\TestCase;

/**
 * R4: news CRUD must not break nor leave orphan images.
 */
class NewsCrudTest extends TestCase
{
    use CreatesUploads, RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @return list<string> */
    private function storedFiles(): array
    {
        return Storage::disk('public')->allFiles();
    }

    /** @param list<string> $paths */
    private function newsWithStoredImages(array $paths): News
    {
        foreach ($paths as $path) {
            Storage::disk('public')->put($path, 'x');
        }

        return News::factory()->withImages($paths)->create();
    }

    public function test_news_with_images_is_created_by_the_logged_in_user(): void
    {
        $this->post('/admin/news', [
            'title' => 'Resgate',
            'description' => 'Texto',
            'images' => [$this->pngUpload('a.png'), $this->pngUpload('b.png')],
        ])->assertRedirect(route('admin.news.index'))->assertSessionHas('success');

        $news = News::query()->sole();
        $this->assertSame('Resgate', $news->title);
        $this->assertSame($this->user->id, (int) $news->author_id);
        $this->assertCount(2, json_decode($news->images, true));
        $this->assertEqualsCanonicalizing(json_decode($news->images, true), $this->storedFiles());
    }

    public function test_news_without_images_is_created(): void
    {
        $this->post('/admin/news', ['title' => 'Resgate', 'description' => 'Texto'])
            ->assertRedirect(route('admin.news.index'));

        $this->assertNull(News::query()->sole()->images);
    }

    /** @return array<string, array{array<string, mixed>}> */
    public static function invalidNews(): array
    {
        return [
            'missing title' => [['title' => null]],
            'title over 255 characters' => [['title' => str_repeat('a', 256)]],
            'missing text' => [['description' => null]],
            'text over 5000 characters' => [['description' => str_repeat('a', 5001)]],
        ];
    }

    /** @param array<string, mixed> $overrides */
    #[DataProvider('invalidNews')]
    public function test_invalid_news_is_refused_and_leaves_no_image(array $overrides): void
    {
        $this->from('/admin/news/create')->post('/admin/news', array_merge([
            'title' => 'Resgate',
            'description' => 'Texto',
            'images' => [$this->pngUpload()],
        ], $overrides))->assertRedirect('/admin/news/create');

        $this->assertDatabaseCount('news', 0);
        $this->assertSame([], $this->storedFiles());
    }

    public function test_one_invalid_file_refuses_the_news_and_stores_none_of_the_images(): void
    {
        $this->post('/admin/news', [
            'title' => 'Resgate',
            'description' => 'Texto',
            'images' => [$this->pngUpload(), $this->upload('photo.jpg', 'not an image')],
        ])->assertRedirect();

        $this->assertDatabaseCount('news', 0);
        $this->assertSame([], $this->storedFiles());
    }

    public function test_failure_while_creating_leaves_no_orphan_image(): void
    {
        News::creating(fn () => throw new \RuntimeException('database down'));

        $this->post('/admin/news', ['title' => 'Resgate', 'description' => 'Texto', 'images' => [$this->pngUpload()]])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('news', 0);
        $this->assertSame([], $this->storedFiles());
    }

    public function test_validation_messages_reach_the_form(): void
    {
        $this->post('/admin/news', ['title' => '', 'description' => 'Texto'])->assertSessionHasErrors(['title']);
    }

    public function test_updating_the_text_keeps_the_images(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->put("/admin/news/{$news->id}", ['title' => 'Título novo', 'description' => 'Texto novo'])
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHas('success');

        $news->refresh();
        $this->assertSame('Título novo', $news->title);
        $this->assertSame('Texto novo', $news->description);
        $this->assertSame(json_encode(['news/a.png']), $news->images);
        Storage::disk('public')->assertExists('news/a.png');
    }

    public function test_updating_with_new_images_adds_them_to_the_existing_ones(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->put("/admin/news/{$news->id}", [
            'title' => 'Título novo',
            'description' => 'Texto novo',
            'images' => [$this->pngUpload()],
        ])->assertSessionHas('success');

        $images = json_decode($news->refresh()->images, true);
        $this->assertCount(2, $images);
        $this->assertSame('news/a.png', $images[0]);
        $this->assertEqualsCanonicalizing($images, $this->storedFiles());
    }

    public function test_invalid_update_changes_nothing(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->put("/admin/news/{$news->id}", ['title' => '', 'description' => 'Texto novo', 'images' => [$this->pngUpload()]])
            ->assertRedirect();

        $fresh = $news->fresh();
        $this->assertSame($news->title, $fresh->title);
        $this->assertSame($news->description, $fresh->description);
        $this->assertSame($news->images, $fresh->images);
        $this->assertSame(['news/a.png'], $this->storedFiles());
    }

    public function test_updating_missing_news_with_images_leaves_no_orphan_image(): void
    {
        $this->put('/admin/news/999', ['title' => 'Resgate', 'description' => 'Texto', 'images' => [$this->pngUpload()]])
            ->assertSessionHas('error');

        $this->assertSame([], $this->storedFiles());
    }

    public function test_deleted_news_leaves_the_site_and_its_images_are_removed(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png', 'news/b.png']);
        $other = $this->newsWithStoredImages(['news/other.png']);

        $this->delete("/admin/news/{$news->id}")
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($news);
        $this->assertNotSoftDeleted($other);
        $this->assertSame(['news/other.png'], $this->storedFiles());
        $this->get('/noticias')->assertOk()->assertDontSee($news->title)->assertSee($other->title);
        $this->get("/noticias/{$news->id}")->assertRedirect(route('public.news'));
    }

    public function test_deleting_missing_news_reports_an_error(): void
    {
        $this->delete('/admin/news/999')->assertRedirect()->assertSessionHas('error');
    }

    public function test_removing_one_image_keeps_the_others(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png', 'news/b.png']);

        $this->postJson("/admin/news/{$news->id}/delete-image", ['image_path' => 'news/a.png'])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame(json_encode(['news/b.png']), $news->refresh()->images);
        $this->assertSame(['news/b.png'], $this->storedFiles());
    }

    public function test_removing_an_image_of_another_record_is_refused(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);
        $this->newsWithStoredImages(['news/other.png']);

        $this->postJson("/admin/news/{$news->id}/delete-image", ['image_path' => 'news/other.png'])
            ->assertNotFound()
            ->assertJson(['success' => false]);

        $this->assertEqualsCanonicalizing(['news/a.png', 'news/other.png'], $this->storedFiles());
    }

    public function test_removing_an_image_without_a_path_changes_nothing(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $response = $this->postJson("/admin/news/{$news->id}/delete-image");

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(json_encode(['news/a.png']), $news->refresh()->images);
        $this->assertSame(['news/a.png'], $this->storedFiles());
    }

    public function test_removing_an_image_without_a_path_is_a_validation_error(): void
    {
        $news = News::factory()->create();

        $this->postJson("/admin/news/{$news->id}/delete-image")->assertUnprocessable();
    }

    public function test_edit_form_opens_with_the_news_data(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->get("/admin/news/{$news->id}/edit")->assertOk()->assertSee($news->title)->assertSee('news/a.png');
    }

    public function test_edit_form_of_missing_news_returns_to_the_list(): void
    {
        $this->get('/admin/news/999/edit')->assertRedirect(route('admin.news.index'))->assertSessionHas('error');
    }

    public function test_published_news_opens_on_the_public_page(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->get("/noticias/{$news->id}")->assertOk()->assertSee($news->title)->assertSee('news/a.png');
    }
}
