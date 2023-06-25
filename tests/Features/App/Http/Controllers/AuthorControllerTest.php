<?php

namespace Tests\Features\App\Http\Controllers;

use DateTime;
use App\Models\Author;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $uri = '/api/v1/authors';

    public function testShouldReturnsListOfAllAuthors()
    {
        Author::factory(5)->create();

        $this->get($this->uri);

        $this->assertResponseStatus(Response::HTTP_PARTIAL_CONTENT);
        $this->seeJsonStructure(['status_code', 'data']);
    }

    public function testShouldRetrieveAnAuthorById()
    {
        $model = Author::factory()->create();

        $this->get("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains([
            ...$model->toArray(),
            'active' => (int) $model->active,
        ]);
    }

    public function testShouldReturnAnErrorIfTheAuthorIdDoesNotExist()
    {
        $this->get("{$this->uri}/0");

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldCreateAnAuthor()
    {
        $model = Author::factory()->make()->toArray();

        $this->post($this->uri, [
            ...$model,
            'password' => '123',
        ]);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('authors', $model);
    }

    public function testShouldSendReceiveAErrorIfPayloadIsIncomplete()
    {
        $model = ['first_name' => 'John'];

        $this->post($this->uri, $model);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testShouldUpdateAnAuthorById()
    {
        $model = Author::factory()->create(['first_name' => 'Alex']);
        $data = [
            ...$model->toArray(),
            'first_name' => 'John',
        ];

        $this->put("{$this->uri}/{$model->id}", $data);

        $this->assertResponseOk();
        $this->seeJsonContains(['updated' => true]);
        $this->seeInDatabase('authors', $data);
    }

    public function testShouldDeleteAnAuthorById()
    {
        $model = Author::factory()->create();

        $this->delete("{$this->uri}/{$model->id}");

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $this->seeInDatabase('authors', [
            'id' => $model->id,
            'deleted_at' => new DateTime('now'),
        ]);
    }
}
