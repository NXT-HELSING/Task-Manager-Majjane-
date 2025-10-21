<div>
    <div class="filter-section">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label-custom-small mb-2">
                    <i class="bi bi-flag me-1"></i>Filtre Priorité
                </label>
                <select wire:model="filterPriority" class="form-control-modern">
                    <option value="">Toutes les priorités</option>
                    <option value="low">🟢 Basse</option>
                    <option value="medium">🟡 Moyenne</option>
                    <option value="high">🔴 Haute</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label-custom-small mb-2">
                    <i class="bi bi-person me-1"></i>Filtre Assigné
                </label>
                <select wire:model="filterAssignedTo" class="form-control-modern">
                    <option value="">Tous les assignés</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <button wire:click="refreshBoard" class="btn btn-secondary-custom w-100">
                    <i class="bi bi-arrow-clockwise me-2"></i>Actualiser
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        @foreach (['todo' => 'À Faire', 'in_progress' => 'En Cours', 'done' => 'Terminé'] as $statusKey => $statusLabel)
            <div class="col-lg-4">
                <div class="kanban-column">
                    <div class="kanban-header">
                        <div class="d-flex align-items-center gap-2">
                            @if($statusKey === 'todo')
                                <div class="kanban-icon todo-icon">📋</div>
                            @elseif($statusKey === 'in_progress')
                                <div class="kanban-icon progress-icon">⚡</div>
                            @else
                                <div class="kanban-icon done-icon">✅</div>
                            @endif
                            <h5 class="kanban-title">{{ $statusLabel }}</h5>
                        </div>
                        <span class="kanban-count">{{ count($tasksByStatus[$statusKey] ?? []) }}</span>
                    </div>
                    <div class="kanban-tasks">
                        @forelse($tasksByStatus[$statusKey] ?? [] as $task)
                            <div class="kanban-task-card" wire:key="{{ $task->id }}">
                                <div class="task-header">
                                    <h6 class="task-title">{{ $task->title }}</h6>
                                    <div class="dropdown">
                                        <button class="task-menu-btn" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($statusKey !== 'todo')
                                                <li><a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $task->id }}, 'todo')">
                                                    <i class="bi bi-list-ul me-2"></i>Déplacer vers À Faire
                                                </a></li>
                                            @endif
                                            @if($statusKey !== 'in_progress')
                                                <li><a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $task->id }}, 'in_progress')">
                                                    <i class="bi bi-play-circle me-2"></i>Déplacer vers En Cours
                                                </a></li>
                                            @endif
                                            @if($statusKey !== 'done')
                                                <li><a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $task->id }}, 'done')">
                                                    <i class="bi bi-check-circle me-2"></i>Déplacer vers Terminé
                                                </a></li>
                                            @endif
                                        </ul>
                                    </div>
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
                                    
                                    @if($task->assignee)
                                        <div class="task-assignee">
                                            <div class="avatar-circle-xs">
                                                {{ substr($task->assignee->name, 0, 1) }}
                                            </div>
                                            <span class="assignee-name">{{ $task->assignee->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="kanban-empty">
                                <div class="empty-icon">📝</div>
                                <p>Aucune tâche dans cette colonne</p>
                                <small>Glissez des tâches ici ou créez-en de nouvelles</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>