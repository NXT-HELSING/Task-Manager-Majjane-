@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="page-header-form">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title mb-2">
                    <i class="bi bi-list-task me-2"></i>Mes Tâches Assignées
                </h1>
                <p class="page-subtitle mb-0">Voici toutes les tâches qui vous ont été assignées</p>
            </div>
            <div>
                <a href="{{ route('projects.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Retour aux Projets
                </a>
            </div>
        </div>
    </div>

    @if($assignedTasks->isEmpty())
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3>Aucune tâche assignée</h3>
            <p>Aucune tâche ne vous a été assignée pour le moment.</p>
            <a href="{{ route('projects.index') }}" class="btn btn-gradient">
                <i class="bi bi-grid-3x3-gap me-2"></i>Voir les Projets
            </a>
        </div>
    @else
        <!-- Tasks by Project -->
        <div class="row g-4">
            @foreach($assignedTasks as $projectTitle => $tasks)
                <div class="col-12">
                    <div class="project-card">
                        <div class="project-card-header">
                            <h5 class="project-title">
                                <i class="bi bi-folder me-2"></i>{{ $projectTitle }}
                                <span class="badge badge-primary ms-2">{{ $tasks->count() }} tâche(s)</span>
                            </h5>
                        </div>
                        <div class="project-card-body">
                            <div class="row g-3">
                                @foreach($tasks as $task)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="task-card">
                                            <div class="task-header">
                                                <h6 class="task-title">{{ $task->title }}</h6>
                                                <span class="task-status task-status-{{ $task->status }}">
                                                    @if($task->status === 'todo')
                                                        <i class="bi bi-list-ul"></i> À Faire
                                                    @elseif($task->status === 'in_progress')
                                                        <i class="bi bi-play-circle"></i> En Cours
                                                    @else
                                                        <i class="bi bi-check-circle"></i> Terminé
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="task-meta">
                                                <span class="task-priority task-priority-{{ $task->priority }}">
                                                    @if($task->priority === 'high')
                                                        🔴 Haute
                                                    @elseif($task->priority === 'medium')
                                                        🟡 Moyenne
                                                    @else
                                                        🟢 Basse
                                                    @endif
                                                </span>
                                                <div class="task-actions">
                                                    <a href="{{ route('projects.show', $task->project) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i>Voir Projet
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Task Card Styles */
.task-card {
    background: white;
    border: 2px solid #f1f5f9;
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
}

.task-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 50px rgba(99, 102, 241, 0.25);
    border-color: #e0e7ff;
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.task-title {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0;
    font-size: 1rem;
    line-height: 1.5;
    flex: 1;
    letter-spacing: -0.2px;
}

.task-status {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.6rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    white-space: nowrap;
}

.task-status-todo {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: #475569;
}

.task-status-in_progress {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}

.task-status-done {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
}

.task-meta {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.task-priority {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.75rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    width: fit-content;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    letter-spacing: 0.3px;
}

.task-priority-low {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 2px solid #6ee7b7;
}

.task-priority-medium {
    background: linear-gradient(135deg, #fed7aa, #fbbf24);
    color: #92400e;
    border: 2px solid #fbbf24;
}

.task-priority-high {
    background: linear-gradient(135deg, #fecaca, #f87171);
    color: #7f1d1d;
    border: 2px solid #f87171;
}

.task-actions {
    margin-top: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(248, 250, 252, 0.8), rgba(241, 245, 249, 0.8));
    border-radius: 20px;
    border: 2px dashed #cbd5e1;
}

.empty-state-icon {
    font-size: 4rem;
    color: #94a3b8;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 700;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}
</style>
@endsection
