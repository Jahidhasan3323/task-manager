<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function list(array $request): LengthAwarePaginator
    {
        return Task::query()->paginate(2);
    }

    public function create(array $request)
    {
        return Task::create($request);
    }

    public function updateStatus(Task $task, array $request): bool
    {
            return $task->update(['status' => $request['status'] === 'complete' ? 0 : 1]);
    }

}
