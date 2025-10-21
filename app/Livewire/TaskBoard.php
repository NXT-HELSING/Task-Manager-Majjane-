<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskBoard extends Component
{
    use AuthorizesRequests;

    public Project $project;
    public $tasksByStatus = [];
    public $filterPriority = null; // null | 'low' | 'medium' | 'high'
    public $filterAssignedTo = null; // optional: filter by user id

    protected $listeners = ['taskAdded' => 'refreshBoard'];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->refreshBoard();
    }

    public function updated($property)
    {
        // when a filter changes, refresh board automatically
        if (in_array($property, ['filterPriority', 'filterAssignedTo'])) {
            $this->refreshBoard();
        }
    }

    public function refreshBoard()
    {
        $query = $this->project->tasks()->with('assignee');

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }
        if ($this->filterAssignedTo) {
            $query->where('assigned_to', $this->filterAssignedTo);
        }

        $tasks = $query->get();

        $this->tasksByStatus = [
            'todo' => $tasks->where('status', 'todo')->values(),
            'in_progress' => $tasks->where('status', 'in_progress')->values(),
            'done' => $tasks->where('status', 'done')->values(),
        ];
    }

    public function changeStatus($taskId, $status)
    {
        $task = Task::findOrFail($taskId);
        $this->authorize('update', $task);
        $task->update(['status' => $status]);
        $this->refreshBoard();
    }

    public function render()
    {
        return view('livewire.task-board', [
            'members' => $this->project->members()->get(), // for filter select
        ]);
    }
}
