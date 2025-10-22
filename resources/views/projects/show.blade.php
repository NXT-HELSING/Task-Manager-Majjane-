@extends('layouts.app')

@section('content')

<div class="page-header-form mb-4">
    <a href="{{ route('projects.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Retour aux Projets
    </a>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h1 class="form-page-title mb-0" style="font-size: 2rem;">
            <i class="bi bi-kanban me-2"></i>{{ $project->title }}
        </h1>
        <span class="badge badge-status badge-{{ $project->status }}">
            @if($project->status === 'active')
                <i class="bi bi-play-circle me-1"></i> Actif
            @elseif($project->status === 'archived')
                <i class="bi bi-pause-circle me-1"></i> Archivé
            @else
                <i class="bi bi-check-circle me-1"></i> Terminé
            @endif
        </span>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="form-card mb-4">
            <h5 class="form-label-custom"><i class="bi bi-card-text me-2"></i>Description</h5>
            <p class="project-description-show" style="color: var(--text-secondary); line-height: 1.6;">
                {{ $project->description }}
            </p>
        </div>

        <div class="form-card">
            <h5 class="form-label-custom">👥 Membres du Projet</h5>
            @if ($project->members && $project->members->isNotEmpty())
                <ul class="member-list">
                    @foreach ($project->members as $member)
                        <li class="member-item">
                            <div class="avatar-circle-sm">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div class="member-details">
                                <span class="member-name">{{ $member->name }}</span>
                                <span class="member-email">{{ $member->email }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: var(--text-secondary);">Aucun membre assigné pour le moment.</p>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="form-card">
            <h5 class="form-label-custom"><i class="bi bi-plus-circle me-2"></i>Ajout Rapide de Tâche</h5>
            @livewire('quick-add-task', ['project' => $project])
        </div>
    </div>
</div>

<div class="mt-5">
    <div class="form-card">
        <h2 class="form-page-title mb-4" style="color: #2d3748; font-size: 2rem;"><i class="bi bi-trello me-2"></i>Tableau de Tâches</h2>
        @livewire('task-board', ['project' => $project])
    </div>
</div>

<style>
    /* Modern Trello-inspired Design */
    .page-header-form {
        animation: fadeInDown 0.6s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-5px);
    }

    .form-page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    /* Modern Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-active {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .badge-archived {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
    }

    .badge-completed {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    /* Modern Member List */
    .member-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .member-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f7fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .member-item:hover {
        background: #edf2f7;
        transform: translateX(4px);
    }

    .avatar-circle-sm {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .member-details {
        display: flex;
        flex-direction: column;
        line-height: 1.4;
    }
    
    .member-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }
    
    .member-email {
        font-size: 0.85rem;
        color: #718096;
    }

    /* Project Description */
    .project-description-show {
        background: #f7fafc;
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        line-height: 1.6;
        color: #4a5568;
        max-height: 200px;
        overflow-y: auto;
    }

    /* Animations */
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


    /* --- STYLES FROM quick-add-task.blade.php --- */

    .form-group-custom {
        position: relative;
        margin-bottom: 1.5rem; /* Added margin-bottom */
    }

    .form-label-custom {
        display: flex;
        align-items: center;
        color: #2d3748;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
        color: #2d3748;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23667eea' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px;
        padding-right: 3rem;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
        transform: translateY(-1px);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23667eea' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    }

    .form-control-modern::placeholder {
        color: #a0aec0;
        font-style: italic;
    }

    select.form-control-modern option {
        background: white;
        color: #2d3748;
        padding: 0.5rem;
    }

    input.form-control-modern {
        background-image: none;
        padding-right: 1rem;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.8rem;
        color: #e53e3e;
        font-weight: 500;
    }

    .is-invalid {
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient:hover::before {
        left: 100%;
    }

    .btn-gradient:active {
        transform: translateY(0);
    }

    .form-control-modern.is-valid {
        border-color: #48bb78;
        box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
    }

    .btn-gradient:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .form-group-custom:focus-within .form-label-custom {
        color: #667eea;
    }


    /* --- STYLES FROM task-board.blade.php --- */

    .filter-section {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-label-custom-small {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .btn-secondary-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.875rem 1.5rem; /* Adjusted padding to match form fields */
        border-radius: 10px; /* Matched radius */
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem; /* Matched font size */
    }

    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .kanban-column {
        background: #f7fafc; /* Slightly off-white bg for columns */
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%; /* Ensure columns fill height */
    }

    .kanban-column:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .kanban-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 1rem 1.25rem; /* Added padding */
        border-bottom: 2px solid #e2e8f0; /* Thicker border */
    }

    .kanban-title {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
        margin: 0;
    }

    .kanban-count {
        background: #667eea;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .kanban-tasks {
        padding: 0 1.25rem 1.25rem; /* Added padding */
        min-height: 200px;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Task Cards */
    .kanban-task-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .kanban-task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .kanban-task-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .kanban-task-card:hover::before {
        transform: scaleX(1);
    }

    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .task-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        line-height: 1.4;
    }
    
    .task-menu-btn {
        background: none;
        border: none;
        color: #a0aec0;
        padding: 0.25rem;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .task-menu-btn:hover {
        background: #f7fafc;
        color: #4a5568;
    }

    .task-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .task-priority {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        width: fit-content; /* Fit to content */
    }

    .task-priority-low {
        background: #c6f6d5;
        color: #22543d;
    }

    .task-priority-medium {
        background: #fef5e7;
        color: #744210;
    }

    .task-priority-high {
        background: #fed7d7;
        color: #742a2a;
    }

    .task-assignee {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .assignee-name {
        font-size: 0.8rem;
        color: #4a5568;
        font-weight: 500;
    }

    .avatar-circle-xs {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.7rem;
        color: white;
    }

    .kanban-empty {
        text-align: center;
        color: #a0aec0;
        font-style: italic;
        padding: 2rem;
        background: white; /* Changed from #f7fafc */
        border-radius: 8px;
        border: 2px dashed #e2e8f0;
    }
    
    .empty-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .kanban-empty p {
        margin-bottom: 0.25rem;
        font-weight: 500;
        color: #718096; /* Darker text */
    }

    .kanban-empty small {
        color: #a0aec0;
    }
    
    .kanban-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white; /* Added color white */
    }

    .todo-icon {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .progress-icon {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .done-icon {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }


    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .form-page-title {
            font-size: 1.5rem;
        }
        
        .page-header-form {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .page-header-form .d-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start !important;
        }
        
        .badge-status {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
        }
        
        .form-card {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .form-label-custom {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }
        
        .project-description-show {
            padding: 1rem;
            font-size: 0.9rem;
        }
        
        .member-list {
            gap: 0.5rem;
        }
        
        .member-item {
            padding: 0.75rem;
        }
        
        .avatar-circle-sm {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }
        
        .member-name {
            font-size: 0.9rem;
        }
        
        .member-email {
            font-size: 0.8rem;
        }
        
        /* Quick Add Task Mobile */
        .form-control-modern {
            padding: 0.75rem;
            font-size: 0.9rem;
        }
        
        .btn-gradient {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
        }
        
        /* Task Board Mobile */
        .filter-section {
            padding: 1rem;
        }
        
        .filter-section .row {
            flex-direction: column;
        }
        
        .filter-section .col-md-4 {
            width: 100%;
            margin-bottom: 1rem;
        }
        
        .btn-secondary-custom {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
        }
        
        .kanban-column {
            margin-bottom: 1.5rem;
        }
        
        .kanban-header {
            padding: 0.75rem 1rem;
        }
        
        .kanban-title {
            font-size: 1rem;
        }
        
        .kanban-count {
            font-size: 0.75rem;
            padding: 0.2rem 0.6rem;
        }
        
        .kanban-tasks {
            padding: 0 1rem 1rem;
        }
        
        .kanban-task-card {
            padding: 0.75rem;
        }
        
        .task-title {
            font-size: 0.9rem;
        }
        
        .task-priority {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }
        
        .assignee-name {
            font-size: 0.75rem;
        }
        
        .avatar-circle-xs {
            width: 20px;
            height: 20px;
            font-size: 0.65rem;
        }
        
        .kanban-empty {
            padding: 1.5rem;
        }
        
        .empty-icon {
            font-size: 1.5rem;
        }
        
        .kanban-empty p {
            font-size: 0.9rem;
        }
        
        .kanban-empty small {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .form-page-title {
            font-size: 1.3rem;
        }
        
        .page-header-form {
            padding: 1rem;
        }
        
        .form-card {
            padding: 1rem;
        }
        
        .project-description-show {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .member-item {
            padding: 0.5rem;
        }
        
        .avatar-circle-sm {
            width: 30px;
            height: 30px;
            font-size: 0.9rem;
        }
        
        .form-control-modern {
            padding: 0.7rem;
            font-size: 0.85rem;
        }
        
        .btn-gradient {
            padding: 0.8rem 1.25rem;
            font-size: 0.85rem;
        }
        
        .filter-section {
            padding: 0.75rem;
        }
        
        .kanban-header {
            padding: 0.5rem 0.75rem;
        }
        
        .kanban-title {
            font-size: 0.9rem;
        }
        
        .kanban-tasks {
            padding: 0 0.75rem 0.75rem;
        }
        
        .kanban-task-card {
            padding: 0.5rem;
        }
        
        .task-title {
            font-size: 0.85rem;
        }
        
        .kanban-empty {
            padding: 1rem;
        }
        
        .empty-icon {
            font-size: 1.2rem;
        }
        
        /* Additional Livewire Mobile Styles */
        .dropdown-menu {
            font-size: 0.8rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 0.75rem;
        }
        
        .task-menu-btn {
            padding: 0.2rem;
        }
        
        .kanban-icon {
            width: 28px;
            height: 28px;
            font-size: 1rem;
        }
    }
    
    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .kanban-task-card {
            touch-action: manipulation;
        }
        
        .task-menu-btn {
            min-width: 32px;
            min-height: 32px;
        }
        
        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        
        .form-control-modern:focus {
            transform: none;
        }
        
        .btn-gradient:hover {
            transform: none;
        }
        
        .btn-secondary-custom:hover {
            transform: none;
        }
    }
</style>
@endsection