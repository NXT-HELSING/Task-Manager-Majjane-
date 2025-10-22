@extends('layouts.app')

@section('content')
<div class="dashboard-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="bi bi-grid-3x3-gap me-2"></i>Mes Projets
            </h1>
            <p class="page-subtitle">Gérez et suivez tous vos projets en un seul endroit</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('projects.create') }}" class="btn btn-gradient">
                <i class="bi bi-plus-circle me-2"></i>Créer un nouveau projet
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
        <h3 class="empty-state-title">Aucun projet pour l’instant</h3>
        <p class="empty-state-text">Commencez par créer votre premier projet et organisez vos tâches</p>
        <a href="{{ route('projects.create') }}" class="btn btn-gradient mt-3">
            <i class="bi bi-plus-circle me-2"></i>Créer votre premier projet
        </a>
    </div>
@else
    <!-- Grille de projets -->
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
                                        <i class="bi bi-play-circle"></i> Actif
                                    @elseif($project->status === 'archived')
                                        <i class="bi bi-pause-circle"></i> Archivé
                                    @else
                                        <i class="bi bi-check-circle"></i> Terminé
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
                                            <i class="bi bi-eye me-2"></i>Voir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('projects.edit', $project) }}">
                                            <i class="bi bi-pencil me-2"></i>Modifier
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Supprimer
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="project-card-body">
                        <p class="project-description">{{ Str::limit($project->description, 120) }}</p>
                        
                        <!-- Statistiques des tâches -->
                        <div class="task-stats">
                            <div class="stat-item">
                                <i class="bi bi-list-task text-primary"></i>
                                <span>{{ $project->tasks->count() }} Tâches</span>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>{{ $project->tasks->where('status', 'done')->count() }} Terminées</span>
                            </div>
                        </div>

                        <!-- Barre de progression -->
                        @php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'done')->count();
                            $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="progress-container">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="progress-label">Progression</small>
                                <small class="progress-value">{{ $progress }}%</small>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <!-- Date d'échéance -->
                        @if($project->due_date)
                            <div class="due-date">
                                <i class="bi bi-calendar-event me-2"></i>
                                Échéance : {{ \Carbon\Carbon::parse($project->due_date)->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    <div class="project-card-footer">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-right-circle me-2"></i>Voir le projet
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
    0%,100% { transform: translateY(0);}
    50% { transform: translateY(-6px);}
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.15rem;
    margin-bottom: 0;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 6rem 2rem;
    animation: fadeIn 0.8s ease;
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.empty-state::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
    background-size: 200% 100%;
    animation: borderSlide 3s ease infinite;
}

@keyframes borderSlide {
    0%,100% { background-position: 0% 0%;}
    50% { background-position: 100% 0%;}
}

.empty-state-icon {
    font-size: 6rem;
    color: #cbd5e1;
    margin-bottom: 2rem;
    opacity: 0.6;
    animation: emptyFloat 3s ease-in-out infinite;
}

@keyframes emptyFloat {
    0%, 100% { transform:translateY(0);}
    50% { transform:translateY(-10px);}
}

.empty-state-title {
    font-size: 2.25rem;
    font-weight: 800;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
}

.empty-state-text {
    color: #64748b;
    font-size: 1.15rem;
    max-width: 500px;
    margin: 0 auto 2rem;
}

/* Cartes de projet améliorées */
.project-card {
    background: white;
    border-radius: 20px;
    border: 2px solid transparent;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInUp 0.6s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    position: relative;
}

.project-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
    background-size: 200% 100%;
    animation: borderSlide 3s ease infinite;
}

.project-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 80px rgba(99, 102, 241, 0.25);
    border-color: rgba(99, 102, 241, 0.2);
}

.project-card-header {
    padding: 1.75rem;
    border-bottom: 2px solid #f1f5f9;
}

.project-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    letter-spacing: -0.3px;
}

/* Badges d'état améliorés */
.badge-status {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}
.badge-status i {
    margin-right: 0.5rem;
    font-size: 0.9rem;
}
.badge-active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.7);}
    50% { box-shadow: 0 0 0 8px rgba(16,185,129,0);}
}
.badge-archived {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}
.badge-completed {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}
.badge-status:hover {
    transform: scale(1.05);
}

/* Bouton icône */
.btn-icon {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #64748b;
    padding: 0.5rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-icon:hover {
    background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(139,92,246,0.1));
    color: #6366f1;
    transform: rotate(90deg);
}

.project-card-body {
    padding: 1.75rem;
    flex-grow: 1;
}
.project-description {
    color: #64748b;
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 1.75rem;
}

/* Statistiques des tâches */
.task-stats {
    display: flex;
    gap: 1.75rem;
    margin-bottom: 1.75rem;
}
.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748b;
    font-size: 0.95rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    background: #f8fafc;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.stat-item:hover {
    background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(139,92,246,0.05));
    transform: scale(1.05);
}
.stat-item i {
    font-size: 1.2rem;
}

/* Barre de progression */
.progress-container {
    margin-bottom: 1.5rem;
}
.progress-label,
.progress-value {
    color: #475569;
    font-size: 0.9rem;
    font-weight: 700;
}
.progress-bar-custom {
    height: 10px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
    background-size: 200% 100%;
    border-radius: 10px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    animation: progressShine 2s ease infinite;
    position: relative;
}
@keyframes progressShine {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}
.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}
@keyframes shimmer {
    0%   { transform: translateX(-100%);}
    100% { transform: translateX(100%);}
}

/* Date d'échéance */
.due-date {
    display: flex;
    align-items: center;
    color: #475569;
    font-size: 0.95rem;
    font-weight: 600;
    padding: 0.875rem 1rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 12px;
    border-left: 4px solid #6366f1;
    transition: all 0.3s ease;
}
.due-date:hover {
    background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(139,92,246,0.05));
    border-left-color: #8b5cf6;
    transform: translateX(3px);
}
.due-date i {
    margin-right: 0.75rem;
    color: #6366f1;
    font-size: 1.1rem;
}
.project-card-footer {
    padding: 1.75rem;
    border-top: 2px solid #f1f5f9;
}

/* Bouton de contour amélioré */
.btn-outline-primary {
    border: 2px solid #e2e8f0;
    color: #6366f1;
    background: transparent;
    font-weight: 700;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    position: relative;
    overflow: hidden;
}
.btn-outline-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    transition: width 0.4s ease;
    z-index: -1;
}
.btn-outline-primary:hover::before {
    width: 100%;
}
.btn-outline-primary:hover {
    border-color: transparent;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(99,102,241,0.4);
}
.btn-outline-primary i {
    margin-right: 0.75rem;
    transition: transform 0.3s ease;
}
.btn-outline-primary:hover i {
    transform: translateX(5px);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0;}
    to   { opacity: 1;}
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px);}
    to   { opacity: 1; transform: translateY(0);}
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px);}
    to   { opacity: 1; transform: translateY(0);}
}

/* Responsive Mobile */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 2rem 1.5rem;
    }
    .page-title {
        font-size: 2rem;
    }
    .page-subtitle {
        font-size: 1rem;
    }
    .empty-state {
        padding: 4rem 1.5rem;
    }
    .empty-state-icon {
        font-size: 4rem;
    }
    .empty-state-title {
        font-size: 1.75rem;
    }
    .project-card-header,
    .project-card-body,
    .project-card-footer {
        padding: 1.25rem;
    }
    .task-stats {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection