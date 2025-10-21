@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="page-header-form mb-4">
            <a href="{{ route('projects.show', $project) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back to Project
            </a>
            <h1 class="form-page-title">
                <i class="bi bi-pencil-square me-2"></i>Edit Project
            </h1>
            <p class="form-page-subtitle">Update the details for your project</p>
        </div>

        <div class="form-card">
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group-custom mb-4">
                    <label for="title" class="form-label-custom">
                        <i class="bi bi-text-left me-2"></i>Project Title
                    </label>
                    <input 
                        type="text" 
                        class="form-control-modern @error('title') is-invalid @enderror" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $project->title) }}" 
                        placeholder="Enter project title..."
                        required
                        autofocus
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-custom mb-4">
                    <label for="description" class="form-label-custom">
                        <i class="bi bi-card-text me-2"></i>Description
                    </label>
                    <textarea 
                        class="form-control-modern @error('description') is-invalid @enderror" 
                        id="description" 
                        name="description" 
                        rows="5" 
                        placeholder="Describe your project goals, scope, and objectives..."
                        required
                    >{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="status" class="form-label-custom">
                                <i class="bi bi-circle-fill me-2"></i>Status
                            </label>
                            <select 
                                class="form-control-modern @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status"
                                required
                            >
                                <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>
                                    On Hold
                                </option>
                                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="due_date" class="form-label-custom">
                                <i class="bi bi-calendar-event me-2"></i>Due Date
                            </label>
                            <input 
                                type="date" 
                                class="form-control-modern @error('due_date') is-invalid @enderror" 
                                id="due_date" 
                                name="due_date" 
                                value="{{ old('due_date', $project->due_date) }}"
                            >
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary-custom">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-check-circle me-2"></i>Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Modern Edit Project Design */
    .page-header-form {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        animation: fadeInDown 0.6s ease;
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

    .form-page-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        margin-bottom: 0;
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

    .form-group-custom {
        position: relative;
    }

    .form-label-custom {
        display: flex;
        align-items: center;
        color: #2d3748;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .form-control-modern {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #2d3748;
        padding: 0.875rem 1.25rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control-modern:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
        color: #2d3748;
        transform: translateY(-1px);
    }

    .form-control-modern::placeholder {
        color: #a0aec0;
        opacity: 0.8;
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 120px;
    }

    select.form-control-modern {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23667eea' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px;
        padding-right: 3rem;
    }

    select.form-control-modern option {
        background: white;
        color: #2d3748;
    }

    .form-control-modern.is-invalid {
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
    }

    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-secondary-custom {
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        color: #4a5568;
        padding: 0.75rem 1.75rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: #edf2f7;
        border-color: #cbd5e0;
        color: #2d3748;
        transform: translateY(-2px);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.75rem 1.75rem;
        border-radius: 10px;
        font-weight: 600;
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
        .form-page-title {
            font-size: 1.8rem;
        }
        
        .form-page-subtitle {
            font-size: 0.9rem;
        }
        
        .page-header-form {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-card {
            padding: 1.5rem;
        }
        
        .form-label-custom {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .form-control-modern {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-secondary-custom,
        .btn-gradient {
            width: 100%;
            padding: 0.875rem 1.5rem;
        }
        
        .row.mb-4 {
            flex-direction: column;
        }
        
        .row.mb-4 .col-md-6 {
            width: 100%;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 480px) {
        .form-page-title {
            font-size: 1.5rem;
        }
        
        .page-header-form {
            padding: 1rem;
        }
        
        .form-card {
            padding: 1rem;
        }
        
        .form-control-modern {
            padding: 0.7rem 0.875rem;
            font-size: 0.85rem;
        }
        
        .form-label-custom {
            font-size: 0.85rem;
        }
        
        .btn-secondary-custom,
        .btn-gradient {
            padding: 0.8rem 1.25rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection