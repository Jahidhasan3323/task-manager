<?php

use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {
    $this->baseUrl = 'api/tasks';
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user, ['*']);
});

it('tasks list column', function () {
    Task::factory()->create();
    $response = $this->getJson($this->baseUrl);
    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'created_at',
                        'deleted_at',
                        'id',
                        'sort_description',
                        'status',
                        'title',
                        'updated_at'
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'next',
                    'prev'
                ],
                'meta' =>  [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]
        ]);
});

it('tasks list column missing', function () {
    Task::factory()->create();
    $response = $this->getJson($this->baseUrl);
    $response->assertOk()
        ->assertJsonMissing([
            'success',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'created_at',
                        'deleted_at',
                        'id',
                        'sort_description',
                        'status',
                        'updated_at'
                    ]
                ],
            ]
        ]);
});

it('create tasks', function () {
    $payload = [
      'title' => 'test task',
      'sort_description' => 'test description'
    ];
    $response = $this->postJson($this->baseUrl, $payload);

    $this->assertEquals(
            $response['data']['title'],
            $payload['title']
        );
});

it('create tasks validation errors', function () {
    $payload = [
      'title' => '',
      'sort_description' => 'test description'
    ];
    $response = $this->postJson($this->baseUrl, $payload);

    $response->assertJsonValidationErrors('title');
});

it('delete task', function () {
    $task = Task::factory()->create();

    $response = $this->deleteJson("$this->baseUrl/$task->id");

    $response->assertOk();
});

it('delete task failed', function () {
    Task::factory()->create();

    $response = $this->deleteJson($this->baseUrl . '/' . 2);

    expect($response->status())->toBeIn([404]);
});



