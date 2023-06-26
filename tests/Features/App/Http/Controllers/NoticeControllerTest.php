<?php

namespace Tests\Features\App\Http\Controllers;

use DateTimeImmutable;
use App\Models\Author;
use App\Models\Notice;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class NoticeControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $uri = '/api/v1/notices';

    public function setUp(): void
    {
        parent::setUp();
        Author::factory(10)->create();
    }

    public function testShouldReturnsListOfAllNotices()
    {
        Notice::factory(5)->create();

        $this->get($this->uri);

        $this->assertResponseStatus(Response::HTTP_PARTIAL_CONTENT);
        $this->seeJsonStructure([
            'status_code',
            'data' => [
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
    }

    public function testShouldRetrieveANoticeById()
    {
        $model = Notice::factory()->create();

        $this->get("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains([
            ...$model->toArray(),
            'active' => (int) $model->active,
        ]);
    }

    public function testShouldReturnAnErrorIfTheNoticeIdDoesNotExist()
    {
        $this->get("{$this->uri}/0");

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldRetrieveANoticeBySlug()
    {
        $model = Notice::factory()->create();

        $this->get("{$this->uri}/slug/{$model->slug}");

        $this->assertResponseOk();
        $this->seeJsonContains([
            ...$model->toArray(),
            'active' => (int) $model->active,
        ]);
    }

    public function testShouldReturnAnErrorIfTheNoticeSlugDoesNotExist()
    {
        $this->get("{$this->uri}/slug/invalid-slug");

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldRetrieveNoticesByAuthorId()
    {
        $author_id = 1;
        Notice::factory(5)->create([
            'author_id' => $author_id,
        ]);

        $this->get("{$this->uri}/author/{$author_id}");

        $this->assertResponseStatus(Response::HTTP_PARTIAL_CONTENT);
        $this->seeJsonContains([
            'author_id' => $author_id,
        ]);
    }

    public function testShouldCreateANotice()
    {
        $model = Notice::factory()->make()->toArray();

        $this->post($this->uri, $model);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('notices', $model);
    }

    public function testShouldGenerateASlugOnCreationIfItIsNotPassed()
    {
        $model = Notice::factory()->make()->toArray();
        unset($model['slug']);

        $this->post($this->uri, $model);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('notices', [
            ...$model,
            'slug' => Str::slug($model['title'] . '-' . $model['subtitle']),
        ]);
    }

    public function testShouldSendReceiveAErrorIfPayloadIsIncomplete()
    {
        $model = ['first_name' => 'John'];

        $this->post($this->uri, $model);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldUpdateANoticeById()
    {
        $model = Notice::factory()->create(['title' => 'Title']);
        $data = [
            ...$model->toArray(),
            'title' => 'New Title',
        ];

        $this->put("{$this->uri}/{$model->id}", $data);

        $this->assertResponseOk();
        $this->seeJsonContains(['updated' => true]);
        $this->seeInDatabase('notices', $data);
    }

    public function testShouldUpdateANoticeBySlug()
    {
        $model = Notice::factory()->create(['title' => 'Title']);
        $data = [
            ...$model->toArray(),
            'title' => 'New Title',
        ];

        $this->put("{$this->uri}/slug/{$model->slug}", $data);

        $this->assertResponseOk();
        $this->seeJsonContains(['updated' => true]);
        $this->seeInDatabase('notices', $data);
    }

    public function testShouldDeleteANoticeById()
    {
        $model = Notice::factory()->create();

        $this->delete("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notices', [
            'id' => $model->id,
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }

    public function testShouldDeleteANoticeBySlug()
    {
        $model = Notice::factory()->create();

        $this->delete("{$this->uri}/slug/{$model->slug}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notices', [
            'id' => $model->id,
            'slug' => $model->slug,
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }

    public function testShouldDeleteNoticesByAuthorId()
    {
        $author_id = 1;
        Notice::factory(5)->create([
            'author_id' => $author_id,
        ]);

        $this->delete("{$this->uri}/{$author_id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notices', [
            'author_id' => $author_id,
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }
}
