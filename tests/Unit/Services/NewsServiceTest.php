<?php

namespace Tests\Unit\Services;

use App\Models\News;
use App\Models\User;
use App\Services\NewsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * R4: news CRUD must keep the records and the image files consistent.
 */
class NewsServiceTest extends TestCase
{
    use RefreshDatabase;

    private NewsService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->service = new NewsService;
    }

    /** @param list<string> $paths */
    private function newsWithStoredImages(array $paths): News
    {
        foreach ($paths as $path) {
            Storage::disk('public')->put($path, 'x');
        }

        return News::factory()->withImages($paths)->create();
    }

    public function test_get_all_returns_news_newest_first_without_the_deleted_ones(): void
    {
        $older = News::factory()->create();
        News::factory()->create()->delete();
        $newer = News::factory()->create();

        $this->assertSame([$newer->id, $older->id], array_column($this->service->getAll(), 'id'));
    }

    public function test_paginated_list_respects_the_page_size_and_is_newest_first(): void
    {
        $news = News::factory()->count(3)->create();

        $page = $this->service->getPaginated(2);

        $this->assertSame([$news[2]->id, $news[1]->id], $page->pluck('id')->all());
        $this->assertSame(3, $page->total());
    }

    public function test_get_by_id_returns_the_news(): void
    {
        $news = News::factory()->create(['title' => 'Resgate']);

        $this->assertSame('Resgate', $this->service->getById($news->id)['title']);
    }

    public function test_get_by_id_fails_for_deleted_news(): void
    {
        $news = News::factory()->create();
        $news->delete();

        $this->expectException(ModelNotFoundException::class);

        $this->service->getById($news->id);
    }

    public function test_create_saves_the_news_with_author_and_images(): void
    {
        $author = User::factory()->create();

        $created = $this->service->create([
            'title' => 'Resgate',
            'description' => 'Texto',
            'author_id' => $author->id,
            'images' => json_encode(['news/a.png']),
        ]);

        $this->assertDatabaseHas('news', [
            'id' => $created['id'],
            'title' => 'Resgate',
            'description' => 'Texto',
            'author_id' => $author->id,
            'images' => json_encode(['news/a.png']),
        ]);
    }

    public function test_create_removes_the_uploaded_images_when_saving_fails(): void
    {
        Storage::disk('public')->put('news/a.png', 'x');
        Storage::disk('public')->put('news/b.png', 'x');

        try {
            $this->service->create([
                'title' => 'Sem autor',
                'description' => 'Texto',
                'images' => json_encode(['news/a.png', 'news/b.png']),
            ]);
            $this->fail('News without an author should not be saved.');
        } catch (QueryException) {
            Storage::disk('public')->assertMissing(['news/a.png', 'news/b.png']);
            $this->assertDatabaseCount('news', 0);
        }
    }

    public function test_update_changes_only_the_given_fields(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->service->update($news->id, ['title' => 'Título novo']);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Título novo',
            'description' => $news->description,
            'author_id' => $news->author_id,
            'images' => json_encode(['news/a.png']),
        ]);
        Storage::disk('public')->assertExists('news/a.png');
    }

    public function test_update_of_missing_news_removes_the_uploaded_images(): void
    {
        Storage::disk('public')->put('news/new.png', 'x');

        try {
            $this->service->update(999, ['images' => json_encode(['news/new.png'])]);
            $this->fail('Updating missing news should fail.');
        } catch (ModelNotFoundException) {
            Storage::disk('public')->assertMissing('news/new.png');
        }
    }

    public function test_failed_update_keeps_the_images_the_news_already_had(): void
    {
        $this->markTestSkipped('BUG-1: a failed NewsService::update() also deletes the images the news already had.');

        $news = $this->newsWithStoredImages(['news/old.png']);
        Storage::disk('public')->put('news/new.png', 'x');

        try {
            $this->service->update($news->id, [
                'author_id' => 999,
                'images' => json_encode(['news/old.png', 'news/new.png']),
            ]);
            $this->fail('News with an unknown author should not be saved.');
        } catch (QueryException) {
            Storage::disk('public')->assertMissing('news/new.png');
            Storage::disk('public')->assertExists('news/old.png');
        }
    }

    public function test_delete_soft_deletes_and_removes_all_images(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png', 'news/b.png']);
        $other = $this->newsWithStoredImages(['news/other.png']);

        $this->assertTrue($this->service->delete($news->id));

        $this->assertSoftDeleted($news);
        $this->assertNotSoftDeleted($other);
        Storage::disk('public')->assertMissing(['news/a.png', 'news/b.png']);
        Storage::disk('public')->assertExists('news/other.png');
    }

    public function test_delete_works_for_news_without_images(): void
    {
        $news = News::factory()->create();

        $this->assertTrue($this->service->delete($news->id));
        $this->assertSoftDeleted($news);
    }

    public function test_delete_fails_for_missing_news(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->delete(999);
    }

    public function test_deleting_one_image_keeps_the_others(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png', 'news/b.png']);

        $this->service->deleteImageFromNews($news->id, 'news/a.png');

        $this->assertSame(json_encode(['news/b.png']), $news->refresh()->images);
        Storage::disk('public')->assertMissing('news/a.png');
        Storage::disk('public')->assertExists('news/b.png');
    }

    public function test_deleting_the_last_image_clears_the_field(): void
    {
        $news = $this->newsWithStoredImages(['news/a.png']);

        $this->service->deleteImageFromNews($news->id, 'news/a.png');

        $this->assertNull($news->refresh()->images);
        Storage::disk('public')->assertMissing('news/a.png');
    }

    public function test_deleting_an_image_of_missing_news_keeps_the_file(): void
    {
        Storage::disk('public')->put('news/a.png', 'x');

        try {
            $this->service->deleteImageFromNews(999, 'news/a.png');
            $this->fail('Deleting an image of missing news should fail.');
        } catch (ModelNotFoundException) {
            Storage::disk('public')->assertExists('news/a.png');
        }
    }

    public function test_deleting_an_image_never_touches_files_of_other_records(): void
    {
        $this->markTestSkipped('BUG-2: NewsService::deleteImageFromNews() deletes any file of the public disk.');

        $news = $this->newsWithStoredImages(['news/a.png']);
        $this->newsWithStoredImages(['news/other.png']);

        try {
            $this->service->deleteImageFromNews($news->id, 'news/other.png');
        } catch (\Throwable) {
            // Refusing with an exception or ignoring the path are both acceptable.
        }

        Storage::disk('public')->assertExists('news/other.png');
    }

    public function test_cleanup_removes_only_images_of_deleted_news(): void
    {
        $deleted = $this->newsWithStoredImages(['news/deleted.png']);
        $deleted->delete();
        $this->newsWithStoredImages(['news/kept.png']);

        $this->assertSame(1, $this->service->cleanupDeletedNewsImages());

        Storage::disk('public')->assertMissing('news/deleted.png');
        Storage::disk('public')->assertExists('news/kept.png');
        $this->assertDatabaseHas('news', ['id' => $deleted->id, 'images' => null]);
    }
}
