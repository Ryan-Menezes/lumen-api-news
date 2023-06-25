<?php

namespace Tests\Features\App\Http\Controllers;

use DateTime;
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
        $this->seeJsonStructure(['status_code', 'data']);
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

        $this->post($this->uri, [
            ...$model,
            'password' => '123',
        ]);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('notice_images', $model);
    }

    public function testShouldSendReceiveAErrorIfPayloadIsIncomplete()
    {
        $model = ['first_name' => 'John'];

        $this->post($this->uri, $model);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldUpdateANoticeImageById()
    {
        $model = NoticeImage::factory()->create([
            'source' => 'http://site.com/fake.jpg',
        ]);
        $data = [
            ...$model->toArray(),
            'source' => 'http://site.com/update.jpg'
        ];

        $this->put("{$this->uri}/{$model->id}", $data);

        $this->assertResponseOk();
        $this->seeJsonContains(['updated' => true]);
        $this->seeInDatabase('notice_images', $data);
    }

    public function testShouldDeleteANoticeImageById()
    {
        $model = NoticeImage::factory()->create();

        $this->delete("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('notice_images', [
            'id' => $model->id,
            'deleted_at' => new DateTime('now'),
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
            'deleted_at' => new DateTime('now'),
        ]);
    }
}
