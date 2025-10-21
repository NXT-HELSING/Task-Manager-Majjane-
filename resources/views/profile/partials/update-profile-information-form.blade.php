@extends('layouts.app')

@section('title', 'Profil - TaskManager Pro')

@section('content')

<div class="page-header-form mb-4">
    <a href="{{ route('projects.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Retour aux Projets
    </a>
    <h1 class="form-page-title">
        <i class="bi bi-person-circle me-2"></i>Mon Profil
    </h1>
    <p class="form-page-subtitle">Gérez vos informations de profil et paramètres de compte</p>
</div>

<div class="row g-4">
    <!-- Profile Information -->
    <div class="col-lg-6">
        <div class="form-card">
            <h5 class="form-label-custom">
                <i class="bi bi-person me-2"></i>Informations du Profil
            </h5>
            
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}" style="display: none;">
                @csrf
            </form>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div class="form-group-custom mb-4">
                    <label for="name" class="form-label-custom">
                        <i class="bi bi-person me-2"></i>Nom
                    </label>
                    <input type="text" 
                           class="form-control-modern @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Entrez votre nom">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group-custom mb-4">
                    <label for="email" class="form-label-custom">
                        <i class="bi bi-envelope me-2"></i>Email
                    </label>
                    <input type="email" 
                           class="form-control-modern @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           autocomplete="username"
                           placeholder="Entrez votre email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3">
                            <div class="alert alert-warning-custom p-3 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <span>
                                    Votre adresse email n'est pas vérifiée.
                                    <button form="send-verification" class="btn btn-link-custom p-0 ms-2 align-baseline">
                                        Cliquez ici pour renvoyer l'email de vérification.
                                    </button>
                                </span>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success-custom mt-2 py-2 px-3" role="alert">
                                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Save Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer
                    </button>
                </div>
                
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success-custom mt-3 py-2 px-3 mb-0" id="profileUpdatedMsg">
                        Enregistré avec succès.
                    </div>
                    <script>
                        setTimeout(function() {
                            var msg = document.getElementById('profileUpdatedMsg');
                            if(msg) msg.style.display = 'none';
                        }, 3000);
                    </script>
                @endif
            </form>
        </div>
    </div>

    <!-- Password Update -->
    <div class="col-lg-6">
        <div class="form-card">
            <h5 class="form-label-custom">
                <i class="bi bi-shield-lock me-2"></i>Modifier le Mot de Passe
            </h5>
            <p class="form-description">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.</p>
            
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div class="form-group-custom mb-4">
                    <label for="update_password_current_password" class="form-label-custom">
                        <i class="bi bi-key me-2"></i>Mot de Passe Actuel
                    </label>
                    <input type="password" 
                           class="form-control-modern @error('current_password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_current_password" 
                           name="current_password" 
                           autocomplete="current-password"
                           placeholder="Entrez votre mot de passe actuel">
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group-custom mb-4">
                    <label for="update_password_password" class="form-label-custom">
                        <i class="bi bi-lock me-2"></i>Nouveau Mot de Passe
                    </label>
                    <input type="password" 
                           class="form-control-modern @error('password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_password" 
                           name="password" 
                           autocomplete="new-password"
                           placeholder="Entrez votre nouveau mot de passe">
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group-custom mb-4">
                    <label for="update_password_password_confirmation" class="form-label-custom">
                        <i class="bi bi-lock-fill me-2"></i>Confirmer le Mot de Passe
                    </label>
                    <input type="password" 
                           class="form-control-modern @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                           id="update_password_password_confirmation" 
                           name="password_confirmation" 
                           autocomplete="new-password"
                           placeholder="Confirmez votre nouveau mot de passe">
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer
                    </button>
                </div>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success-custom mt-3 py-2 px-3 mb-0" id="passwordUpdatedMsg">
                        Mot de passe mis à jour avec succès.
                    </div>
                    <script>
                        setTimeout(function() {
                            var msg = document.getElementById('passwordUpdatedMsg');
                            if(msg) msg.style.display = 'none';
                        }, 3000);
                    </script>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Section -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="form-card danger-card">
            <h5 class="form-label-custom text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Supprimer le Compte
            </h5>
            <p class="form-description text-danger">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. 
                Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.
            </p>
            
            <button type="button" class="btn btn-danger-custom" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                <i class="bi bi-trash me-2"></i>Supprimer le Compte
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirmer la Suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <p class="mb-3">
                        Êtes-vous sûr de vouloir supprimer votre compte ? Une fois supprimé, toutes les ressources et données 
                        de votre compte seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer 
                        que vous souhaitez supprimer définitivement votre compte.
                    </p>
                    
                    <div class="form-group-custom">
                        <label for="password" class="form-label-custom">
                            <i class="bi bi-key me-2"></i>Mot de Passe
                        </label>
                        <input type="password" 
                               class="form-control-modern @error('password', 'userDeletion') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Entrez votre mot de passe">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-danger-custom">
                        <i class="bi bi-trash me-2"></i>Supprimer le Compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Modern Profile Design */
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
        height: 100%;
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

    .danger-card {
        border-left: 4px solid #e53e3e;
    }

    .danger-card::before {
        background: linear-gradient(90deg, #e53e3e, #c53030);
    }

    .form-label-custom {
        display: flex;
        align-items: center;
        color: #2d3748;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .form-description {
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .form-group-custom {
        position: relative;
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
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-control-modern::placeholder {
        color: #a0aec0;
        font-style: italic;
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
        padding: 0.875rem 2rem;
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

    .btn-danger-custom {
        background: linear-gradient(135deg, #e53e3e, #c53030);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
    }

    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4);
        color: white;
    }

    .btn-link-custom {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-link-custom:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Alert Styles */
    .alert-warning-custom {
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.1) 0%, rgba(221, 107, 32, 0.1) 100%);
        color: #dd6b20;
        border-left: 4px solid #dd6b20;
        border-radius: 8px;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        color: #38a169;
        border-left: 4px solid #38a169;
        border-radius: 8px;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid #e2e8f0;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #e2e8f0;
        padding: 1.5rem;
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
            margin-bottom: 1rem;
        }
        
        .form-label-custom {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }
        
        .form-control-modern {
            padding: 0.75rem;
            font-size: 0.9rem;
        }
        
        .form-description {
            font-size: 0.85rem;
        }
        
        .btn-gradient,
        .btn-danger-custom {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .btn-secondary-custom {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            width: 100%;
        }
        
        .text-end {
            text-align: center !important;
        }
        
        .alert-warning-custom,
        .alert-success-custom {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .modal-content {
            margin: 1rem;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }
        
        .modal-footer {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .modal-footer .btn {
            width: 100%;
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
            padding: 0.7rem;
            font-size: 0.85rem;
        }
        
        .form-label-custom {
            font-size: 0.85rem;
        }
        
        .btn-gradient,
        .btn-danger-custom,
        .btn-secondary-custom {
            padding: 0.8rem 1.25rem;
            font-size: 0.85rem;
        }
        
        .alert-warning-custom,
        .alert-success-custom {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
        
        .modal-content {
            margin: 0.5rem;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 0.75rem;
        }
    }
</style>
@endsection
