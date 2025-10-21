@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 200px);">
        <div class="col-md-6 col-lg-5">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <div class="auth-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h2 class="auth-title">Create Account</h2>
                    <p class="auth-subtitle">Join TaskFlow Pro and boost your productivity</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-floating-custom mb-3">
                        <input 
                            type="text" 
                            class="form-control-custom @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            placeholder="Full Name"
                        >
                        <label for="name">
                            <i class="bi bi-person me-2"></i>Full Name
                        </label>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-floating-custom mb-3">
                        <input 
                            type="email" 
                            class="form-control-custom @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="Email address"
                        >
                        <label for="email">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating-custom mb-3">
                        <input 
                            type="password" 
                            class="form-control-custom @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            required
                            placeholder="Password"
                        >
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating-custom mb-4">
                        <input 
                            type="password" 
                            class="form-control-custom" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            placeholder="Confirm Password"
                        >
                        <label for="password_confirmation">
                            <i class="bi bi-lock-fill me-2"></i>Confirm Password
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-gradient w-100 mb-3">
                        <i class="bi bi-rocket-takeoff me-2"></i>Create Account
                    </button>

                    <!-- Login Link -->
                    <p class="text-center mb-0" style="color: var(--text-secondary);">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-link">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse same styles from login.blade.php */
    .auth-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 3rem 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-gradient);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
        animation: bounceIn 0.8s ease;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    .auth-title {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .auth-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    .form-floating-custom {
        position: relative;
    }

    .form-control-custom {
        background: rgba(30, 41, 59, 0.5);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        color: var(--text-primary);
        padding: 1rem 1rem 1rem 3rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control-custom:focus {
        background: rgba(30, 41, 59, 0.8);
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-floating-custom label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        pointer-events: none;
        background: transparent;
    }

    .form-control-custom:focus + label,
    .form-control-custom:not(:placeholder-shown) + label {
        top: -10px;
        left: 1rem;
        font-size: 0.75rem;
        color: #667eea;
        background: var(--card-bg);
        padding: 0 0.5rem;
    }

    .text-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .text-link:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .invalid-feedback {
        color: #f45c43;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-control-custom.is-invalid {
        border-color: #f45c43;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .container {
            padding: 0 1rem;
        }
        
        .auth-card {
            padding: 2rem 1.5rem;
            margin: 1rem 0;
        }
        
        .auth-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
        
        .auth-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control-custom {
            padding: 0.875rem 0.875rem 0.875rem 2.5rem;
            font-size: 0.9rem;
        }
        
        .form-floating-custom label {
            left: 0.875rem;
            font-size: 0.85rem;
        }
        
        .form-control-custom:focus + label,
        .form-control-custom:not(:placeholder-shown) + label {
            left: 0.875rem;
            font-size: 0.7rem;
        }
        
        .btn-gradient {
            padding: 0.875rem;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 1.5rem 1rem;
        }
        
        .auth-title {
            font-size: 1.3rem;
        }
        
        .form-control-custom {
            padding: 0.75rem 0.75rem 0.75rem 2.25rem;
        }
        
        .form-floating-custom label {
            left: 0.75rem;
        }
        
        .form-control-custom:focus + label,
        .form-control-custom:not(:placeholder-shown) + label {
            left: 0.75rem;
        }
    }
</style>
@endsection