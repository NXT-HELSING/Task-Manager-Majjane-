<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'priority',
        'status',
        'assigned_to',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scope for filtering by priority
    public function scopePriority($query, $priority)
    {
        return $priority ? $query->where('priority', $priority) : $query;
    }

    // Scope for filtering by assigned user
    public function scopeAssignedTo($query, $userId)
    {
        return $userId ? $query->where('assigned_to', $userId) : $query;
    }
}
