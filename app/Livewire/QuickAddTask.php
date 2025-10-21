<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuickAddTask extends Component
{
    use AuthorizesRequests;

    public Project $project;
    public $title = '';
    public $priority = 'medium';
    public $assigned_to = null;
    public $members = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'priority' => 'required|in:low,medium,high',
        'assigned_to' => 'nullable|exists:users,id',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;

        // ✅ Load all users (so any user can be assigned a task)
        $this->members = \App\Models\User::all();

        // Optional: ensure project owner is always available
        if (!$this->members->contains('id', $project->user_id)) {
            $this->members->push($project->owner()->first());
        }
    }

    public function submit()
    {
        $this->validate();

        $this->authorize('create', $this->project);

        $task = Task::create([
            'project_id' => $this->project->id,
            'title' => $this->title,
            'priority' => $this->priority,
            'assigned_to' => $this->assigned_to,
            'status' => 'todo',
        ]);

        // ✅ Automatically add assigned user as project member (if not already)
        if ($task->assigned_to && !$task->project->members->contains($task->assigned_to)) {
            $task->project->members()->attach($task->assigned_to);
        }

        $this->reset(['title', 'priority', 'assigned_to']);
        $this->dispatch('taskAdded');
        $this->dispatch('notify', message: 'Tâche ajoutée avec succès 🎉');
    }

    public function render()
    {
        return view('livewire.quick-add-task');
    }
}
