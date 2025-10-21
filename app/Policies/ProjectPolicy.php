<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project)
    {
        // Allow the creator or a member to view it
        return $user->id === $project->user_id || $project->members->contains($user->id);
    }

    public function update(User $user, Project $project)
    {
        return $project->user_id === $user->id;
    }

    public function delete(User $user, Project $project)
    {
        return $project->user_id === $user->id;
    }

    public function create(User $user)
    {
        // Allow any authenticated user to create a project
        return $user !== null;
    }
}
