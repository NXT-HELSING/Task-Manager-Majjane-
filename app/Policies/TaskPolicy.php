<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user, $project)
    {
        return $project->user_id === $user->id || $project->members->contains($user);
    }

    // Allow update if user is project owner OR is the assignee
    public function update(User $user, Task $task)
    {
        return $task->project->user_id === $user->id || $task->assigned_to === $user->id;
    }

    public function delete(User $user, Task $task)
    {
        return $task->project->user_id === $user->id;
    }
}
