<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    // 👤 Project owner (creator)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Relation: project members (many-to-many with users)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    // 📋 Project has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
