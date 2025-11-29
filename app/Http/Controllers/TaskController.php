<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{

    private function tasksQuery(?int $userId = null): Builder
    {
        $userId ??= auth()->id();
        return Task::query()
            ->where('user_id', $userId)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc');
    }

    public function today(): Response
    {
        return Inertia::render('tasks/Today', [
            'tasks' => $this->tasksQuery()
                ->whereDate('date', today())
                ->get()
        ]);
    }

    public function upcoming(): Response
    {
        return Inertia::render('tasks/Upcoming', [
            'tasks' => $this->tasksQuery()
                ->whereDate('date', '>', today())
                ->get()
        ]);
    }

    public function history(): Response
    {
        return Inertia::render('tasks/History', [
            'tasks' => $this->tasksQuery()
                ->whereDate('date', '<', today())
                ->get()
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return back()->with('success', 'Task updated successfully.');
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $request->user()->tasks()->create($request->validated());
        return back()->with('success', 'Task created successfully.');
    }
}
