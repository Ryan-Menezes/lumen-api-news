<?php

namespace Tests\Features\App\Http\Controllers;

use App\Helpers\ImageBase64Helper;
use DateTimeImmutable;
use App\Models\Author;
use App\Models\Notice;
use App\Models\NoticeImage;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class NoticeImageControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $uri = '/api/v1/notices-images';

    public function setUp(): void
    {
        parent::setUp();
        Author::factory(10)->create();
        Notice::factory(10)->create();
    }

    public function testShouldReturnsListOfAllNoticesImages()
    {
        NoticeImage::factory(5)->create();

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

    public function testShouldRetrieveANoticeImageById()
    {
        $model = NoticeImage::factory()->create();

        $this->get("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains([
            ...$model->toArray(),
            'active' => (int) $model->active,
        ]);
    }

    public function testShouldReturnAnErrorIfTheNoticeImageIdDoesNotExist()
    {
        $this->get("{$this->uri}/0");

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldRetrieveImagesByNoticeId()
    {
        $notice_id = 1;
        NoticeImage::factory(5)->create([
            'notice_id' => $notice_id,
        ]);

        $this->get("{$this->uri}/notice/{$notice_id}");

        $this->assertResponseStatus(Response::HTTP_OK);
        $this->seeJsonContains([
            'notice_id' => $notice_id,
        ]);
    }

    public function testShouldCreateANoticeImage()
    {
        $model = NoticeImage::factory()->make()->toArray();

        $this->post($this->uri, $model);

        $model['source'] = ImageBase64Helper::generate($model['source']);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('notice_images', $model);
    }

    public function testShouldSendReceiveAErrorIfPayloadIsIncomplete()
    {
        $this->post($this->uri, []);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJsonContains([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'error' => true,
            'error_message' => 'Invalid data',
            'error_description' => [
                'notice_id' => [
                    'The notice id field is required.',
                ],
                'source' => [
                    'The source field is required.',
                ],
                'description' => [
                    'The description field is required.',
                ],
            ],
        ]);
    }

    public function testShouldUpdateANoticeImageById()
    {
        $model = NoticeImage::factory()->create([
            'source' => 'https://via.placeholder.com/640x480.png/00bbaa?text=ab',
        ]);
        $data = [
            ...$model->toArray(),
            'source' => 'https://via.placeholder.com/640x480.png/00bbaa?text=abcd'
        ];

        $this->put("{$this->uri}/{$model->id}", $data);

        $this->assertResponseOk();
        $this->seeJsonContains(['updated' => true]);
        $this->seeInDatabase('notice_images', [
            'id' => $data['id'],
            'source' => ImageBase64Helper::generate($data['source']),
        ]);
    }

    public function testShouldDeleteANoticeImageById()
    {
        $model = NoticeImage::factory()->create();

        $this->delete("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notice_images', [
            'id' => $model->id,
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }

    public function testShouldDeleteImagesByNoticeId()
    {
        $notice_id = 1;
        NoticeImage::factory(5)->create([
            'notice_id' => $notice_id,
        ]);

        $this->delete("{$this->uri}/notice/{$notice_id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notice_images', [
            'notice_id' => $notice_id,
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }
}
