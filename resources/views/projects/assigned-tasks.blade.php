@extends('layouts.app')

@section('content')
<div class="dashboard-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="bi bi-person-check me-2"></i>Mes Tâches Assignées
            </h1>
            <p class="page-subtitle">Tâches qui vous sont assignées dans tous les projets</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('projects.index') }}" class="btn btn-gradient">
                <i class="bi bi-grid-3x3-gap me-2"></i>Mes Projets
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
        <h3 class="empty-state-title">Aucune tâche assignée</h3>
        <p class="empty-state-text">Vous n'avez aucune tâche assignée pour le moment</p>
        <a href="{{ route('projects.index') }}" class="btn btn-gradient mt-3">
            <i class="bi bi-grid-3x3-gap me-2"></i>Voir mes projets
        </a>
    </div>
@else
    <!-- Grille de tâches assignées -->
    <div class="row">
        @foreach($assignedTasks as $task)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="project-card">
                    <div class="project-card-header">
                        <div class="project-title-section">
                            <h3 class="project-title">{{ $task->title }}</h3>
                            @if($task->priority === 'high')
                                <span class="priority-badge priority-high">
                                    <i class="bi bi-circle-fill me-1"></i>HAUTE
                                </span>
                            @elseif($task->priority === 'medium')
                                <span class="priority-badge priority-medium">
                                    <i class="bi bi-circle-fill me-1"></i>MOYENNE
                                </span>
                            @else
                                <span class="priority-badge priority-low">
                                    <i class="bi bi-circle-fill me-1"></i>FAIBLE
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="project-card-body">
                        @if($task->description)
                            <p class="project-description">{{ Str::limit($task->description, 100) }}</p>
                        @endif

                        <!-- Informations du projet -->
                        <div class="project-info">
                            <div class="project-folder">
                                <i class="bi bi-folder me-2"></i>
                                {{ $task->project->title }}
                            </div>

                            <!-- Statut de la tâche -->
                            <div class="project-status">
                                <i class="bi bi-flag me-2"></i>
                                @if($task->status === 'todo')
                                    <span class="status-badge status-todo">
                                        <i class="bi bi-file-text me-1"></i>À Faire
                                    </span>
                                @elseif($task->status === 'in_progress')
                                    <span class="status-badge status-progress">
                                        <i class="bi bi-clock me-1"></i>En Cours
                                    </span>
                                @else
                                    <span class="status-badge status-done">
                                        <i class="bi bi-check-circle me-1"></i>Terminé
                                    </span>
                                @endif
                            </div>

                            <!-- Assigné par -->
                            @if($task->project->owner)
                                <div class="assigned-by">
                                    <i class="bi bi-person me-2"></i>
                                    Assigné par: {{ $task->project->owner->name }}
                                </div>
                            @endif

                            <!-- Date de création -->
                            <div class="task-date">
                                <i class="bi bi-calendar-event me-2"></i>
                                Créé le: {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="project-card-footer">
                        <a href="{{ route('projects.show', $task->project) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-right-circle me-2"></i>Voir le Projet
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
/* En-tête du tableau de bord moderne */
.dashboard-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    background-size: 200% 200%;
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 3rem;
    color: white;
    animation: gradientAnimation 8s ease infinite, fadeInDown 0.6s ease;
    box-shadow: 0 20px 60px rgba(99, 102, 241, 0.3);
    position: relative;
    overflow: hidden;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}

.page-title {
    font-size: 3rem;
    font-weight: 900;
    color: white;
    margin-bottom: 0.75rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    letter-spacing: -1px;
    position: relative;
    z-index: 1;
}

.page-title i {
    animation: iconBounce 2s ease-in-out infinite;
}

@keyframes iconBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.page-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
}

/* Cartes de projet modernes */
.project-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.project-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.project-card-header {
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.project-title-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.project-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
    flex: 1;
}

/* Badges de priorité */
.priority-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.priority-high {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #dc2626;
    border: 1px solid #fecaca;
}

.priority-medium {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #d97706;
    border: 1px solid #fde68a;
}

.priority-low {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #059669;
    border: 1px solid #a7f3d0;
}

.project-card-body {
    padding: 1rem 1.5rem;
    flex: 1;
}

.project-description {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.project-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.project-folder,
.project-status,
.assigned-by,
.task-date {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    color: #6b7280;
}

.project-folder i,
.project-status i,
.assigned-by i,
.task-date i {
    color: #9ca3af;
    width: 16px;
}

/* Badges de statut */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-todo {
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}

.status-progress {
    background: #dbeafe;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}

.status-done {
    background: #d1fae5;
    color: #059669;
    border: 1px solid #a7f3d0;
}

.project-card-footer {
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

/* Boutons */
.btn-gradient {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: white;
}

.btn-outline-primary {
    border: 2px solid #8b5cf6;
    color: #8b5cf6;
    background: transparent;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #8b5cf6;
    color: white;
    transform: translateY(-2px);
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.empty-state-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    color: #6b7280;
    margin-bottom: 2rem;
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .dashboard-header {
        padding: 2rem 1.5rem;
    }
    
    .project-title-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
@endsection
