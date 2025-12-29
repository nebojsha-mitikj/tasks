<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UpdateTaskLabelsRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{

    private function tasksQuery(?int $userId = null, bool $latestFirst = false): Builder
    {
        $userId ??= auth()->id();
        return Task::query()
            ->with('labels')
            ->where('user_id', $userId)
            ->orderBy('date', $latestFirst ? 'DESC' : 'ASC')
            ->orderByRaw(
                "FIELD(status, '" . implode("','", TaskStatusEnum::ordered()) . "')"
            )
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
            'tasksByDate' => $this->tasksQuery()
                ->whereBetween('date', [today()->addDay(), today()->addDays(7)])
                ->get()
                ->groupBy(fn ($task) => $task->date->toDateString())
        ]);
    }

    public function history(): Response
    {
        return Inertia::render('tasks/History', [
            'tasksByDate' => $this->tasksQuery(latestFirst: true)
                ->whereDate('date', '<', today())
                ->get()
                ->groupBy(fn ($task) => $task->date->toDateString())
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

    public function updateStatus(UpdateStatusRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return back()->with('success', 'Task status updated successfully.');
    }

    public function updateLabels(UpdateTaskLabelsRequest $request, Task $task): RedirectResponse
    {
        $task->labels()->sync($request->label_ids);
        return back()->with('success', 'Task labels updated successfully.');
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $request->user()->tasks()->create($request->validated());
        return back()->with('success', 'Task created successfully.');
    }
}
