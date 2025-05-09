<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    public function __construct(private readonly TaskService $taskService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->sendResponse(
           new TaskResource($this->taskService->list($request->only('page'))),
            'Date get successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        return $this->sendResponse(
            $this->taskService->create($request->validated()),
            'Task created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        return $this->sendResponse(
           $task,
            'Task get successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        return $this->sendResponse(
            $task->update($request->validated()),
            'Task updated successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function completeTask(Request $request, Task $task): JsonResponse
    {
        $data = $this->taskService->updateStatus($task, $request->only('status'));
        if ($data) {
            return $this->sendResponse(
                true,
                'Status updated successfully'
            );
        } else {
            return $this->sendError(
                false,
                'Status updated Failed'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        try {
            return $this->sendResponse($task->delete(), 'Task deleted Successfully');
        } catch (\Throwable $throwable) {
            return $this->sendError($throwable->getMessage());
        }
    }
}
