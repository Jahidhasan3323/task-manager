<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('can create a task', function () {

    $task = Task::create([
        'title' => 'Test Title',
        'sort_description' => 'Test body content.',
    ]);

    expect($task->title)->toBe('Test Title')
        ->and($task->sort_description)->toBe('Test body content.');

    $this->assertDatabaseHas('tasks', [
        'title' => 'Test Title',
        'sort_description' => 'Test body content.',
    ]);
});

it('can delete a task', function () {

    $task = Task::create([
        'title' => 'Test Title for delete',
        'sort_description' => 'Test body content for delete',
    ]);

    $task->forceDelete();

    // Assert that the post no longer exists in the database
    $this->assertDatabaseMissing('tasks', [
        'title' => 'Test Title for delete',
        'sort_description' => 'Test body content for delete',
    ]);
});



