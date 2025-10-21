<div>
    {{-- Modern Quick Add Task Form --}}
    <form wire:submit.prevent="submit">
        
        <div class="form-group-custom mb-4">
            <label for="task-title" class="form-label-custom">
                <i class="bi bi-pencil-square me-2"></i>Titre de la Tâche
            </label>
            <input type="text" id="task-title" wire:model="title" 
                   class="form-control-modern @error('title') is-invalid @enderror" 
                   placeholder="Entrez le titre de la tâche...">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group-custom mb-4">
            <label for="task-priority" class="form-label-custom">
                <i class="bi bi-flag me-2"></i>Niveau de Priorité
            </label>
            <select id="task-priority" wire:model="priority" 
                    class="form-control-modern @error('priority') is-invalid @enderror">
                <option value="low">🟢 Priorité Basse</option>
                <option value="medium">🟡 Priorité Moyenne</option>
                <option value="high">🔴 Priorité Haute</option>
            </select>
            @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group-custom mb-4">
            <label for="task-assigned" class="form-label-custom">
                <i class="bi bi-person-plus me-2"></i>Assigner à
            </label>
            <select id="task-assigned" wire:model="assigned_to" 
                    class="form-control-modern @error('assigned_to') is-invalid @enderror">
                <option value="">⚪ Non assigné</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">👤 {{ $member->name }}</option>
                @endforeach
            </select>
            @error('assigned_to') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-gradient w-100">
                <i class="bi bi-plus-circle me-2"></i>Créer la Tâche
            </button>
        </div>
    </form>
</div>