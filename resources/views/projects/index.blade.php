@extends('layouts.app')

@section('content')
<div class="dashboard-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="bi bi-grid-3x3-gap me-2"></i>My Projects
            </h1>
            <p class="page-subtitle">Manage and track all your projects in one place</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('projects.create') }}" class="btn btn-gradient">
                <i class="bi bi-plus-circle me-2"></i>Create New Project
            </a>
        </div>
    </div>
</div>

@if($projects->isEmpty())
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h3 class="empty-state-title">No Projects Yet</h3>
        <p class="empty-state-text">Start by creating your first project and organizing your tasks</p>
        <a href="{{ route('projects.create') }}" class="btn btn-gradient mt-3">
            <i class="bi bi-plus-circle me-2"></i>Create Your First Project
        </a>
    </div>
@else
    <!-- Projects Grid -->
    <div class="row g-4">
        @foreach($projects as $project)
            <div class="col-md-6 col-lg-4">
                <div class="project-card">
                    <div class="project-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="project-title">{{ $project->title }}</h5>
                                <span class="badge badge-status badge-{{ $project->status }}">
                                    @if($project->status === 'active')
                                        <i class="bi bi-play-circle"></i> Active
                                    @elseif($project->status === 'on_hold')
                                        <i class="bi bi-pause-circle"></i> On Hold
                                    @else
                                        <i class="bi bi-check-circle"></i> Completed
                                    @endif
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn-icon" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('projects.show', $project) }}">
                                            <i class="bi bi-eye me-2"></i>View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('projects.edit', $project) }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="project-card-body">
                        <p class="project-description">{{ Str::limit($project->description, 120) }}</p>
                        
                        <!-- Task Stats -->
                        <div class="task-stats">
                            <div class="stat-item">
                                <i class="bi bi-list-task text-primary"></i>
                                <span>{{ $project->tasks->count() }} Tasks</span>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>{{ $project->tasks->where('status', 'done')->count() }} Done</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'done')->count();
                            $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="progress-container">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="progress-label">Progress</small>
                                <small class="progress-value">{{ $progress }}%</small>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <!-- Due Date -->
                        @if($project->due_date)
                            <div class="due-date">
                                <i class="bi bi-calendar-event me-2"></i>
                                Due: {{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}
                            </div>
                        @endif
                    </div>

                    <div class="project-card-footer">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-right-circle me-2"></i>View Project
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
    /* Modern Projects Index Design */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        animation: fadeInDown 0.6s ease;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        animation: fadeIn 0.8s ease;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #a0aec0;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: #718096;
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Modern Project Cards */
    .project-card {
        background: white;
        border-radius: 16px;
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .project-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .project-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .project-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-active {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .badge-on_hold {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
    }

    .badge-completed {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-icon {
        background: transparent;
        border: none;
        color: #a0aec0;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-icon:hover {
        background: #f7fafc;
        color: #4a5568;
    }

    .project-card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }

    .project-description {
        color: #718096;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .task-stats {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #718096;
        font-size: 0.9rem;
    }

    .stat-item i {
        font-size: 1.1rem;
    }

    .progress-container {
        margin-bottom: 1rem;
    }

    .progress-label,
    .progress-value {
        color: #4a5568;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .progress-bar-custom {
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 10px;
        transition: width 0.6s ease;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.3);
    }

    .due-date {
        display: flex;
        align-items: center;
        color: #4a5568;
        font-size: 0.9rem;
        padding: 0.75rem;
        background: #f7fafc;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .project-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: transparent;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Modern Button Styles */
    .btn-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }
        
        .page-subtitle {
            font-size: 1rem;
        }
        
        .dashboard-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .dashboard-header .row {
            flex-direction: column;
            gap: 1rem;
        }
        
        .dashboard-header .col-md-6 {
            text-align: center;
        }
        
        .dashboard-header .text-md-end {
            text-align: center !important;
        }
        
        .btn-gradient {
            width: 100%;
            padding: 0.875rem 1.5rem;
        }
        
        .empty-state {
            padding: 3rem 1.5rem;
        }
        
        .empty-state-icon {
            font-size: 4rem;
        }
        
        .empty-state-title {
            font-size: 1.5rem;
        }
        
        .empty-state-text {
            font-size: 1rem;
        }
        
        .project-card {
            margin-bottom: 1rem;
        }
        
        .project-card-header {
            padding: 1rem;
        }
        
        .project-card-body {
            padding: 1rem;
        }
        
        .project-card-footer {
            padding: 1rem;
        }
        
        .project-title {
            font-size: 1.1rem;
        }
        
        .task-stats {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .stat-item {
            justify-content: center;
        }
        
        .due-date {
            font-size: 0.85rem;
            padding: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .dashboard-header {
            padding: 1rem;
        }
        
        .empty-state {
            padding: 2rem 1rem;
        }
        
        .empty-state-icon {
            font-size: 3rem;
        }
        
        .empty-state-title {
            font-size: 1.3rem;
        }
        
        .project-card-header,
        .project-card-body,
        .project-card-footer {
            padding: 0.75rem;
        }
        
        .project-title {
            font-size: 1rem;
        }
        
        .badge-status {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
        }
        
        .task-stats {
            gap: 0.5rem;
        }
        
        .stat-item {
            font-size: 0.8rem;
        }
        
        .due-date {
            font-size: 0.8rem;
            padding: 0.4rem;
        }
    }
</style>
@endsection