<?php

namespace Tests\Features\App\Http\Controllers;

use DateTimeImmutable;
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
        $model = Author::factory()->make([
            'email' => 'test@gmail.com',
        ])->toArray();

        $this->post($this->uri, [
            ...$model,
            'password' => '123456',
        ]);

        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonContains($model);
        $this->seeInDatabase('authors', $model);
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
                'first_name' => [
                    'The first name field is required.',
                ],
                'last_name' => [
                    'The last name field is required.',
                ],
                'email' => [
                    'The email field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
                'gender' => [
                    'The gender field is required.',
                ],
            ],
        ]);
    }

    public function testShouldUpdateAnAuthorById()
    {
        $model = Author::factory()->create([
            'first_name' => 'Alex',
            'email' => 'test@gmail.com',
        ]);
        $data = [
            ...$model->toArray(),
            'first_name' => 'John',
        ];

        $this->put("{$this->uri}/{$model->id}", [
            ...$data,
            'password' => '123456',
        ]);

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
            'deleted_at' => new DateTimeImmutable('now'),
        ]);
    }
}
