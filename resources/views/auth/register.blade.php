<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .inscription-title {
        font-weight: bold;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .red-underline {
        height: 4px;
        width: 120px;
        background-color: #dc3545;
        margin-bottom: 2rem;
        border-radius: 2px;
    }
    
    .registration-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 2rem;
        border: none;
    }
    
    .form-control {
        border-radius: 25px;
        padding: 0.75rem 1.25rem;
        border: 1px solid #e2e8f0;
        margin-bottom: 1rem;
    }
    
    .btn-register {
        background-color: #f05454;
        color: white;
        border-radius: 25px;
        padding: 0.75rem;
        font-weight: 600;
        border: none;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-register:hover {
        background-color: #e03444;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .login-link {
        color: #4299e1;
        text-decoration: none;
        font-weight: 500;
    }
    
    .login-link:hover {
        text-decoration: underline;
    }
    
    .register-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    
    .register-image {
        max-height: 400px;
    }
</style>
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card registration-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-none d-md-block">
                            <div class="register-image-container">
                                <img src="{{ asset('images/register.png') }}" alt="Registration" class="img-fluid register-image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="text-center inscription-title">INSCRIPTION</h1>
                            <div class="red-underline mx-auto"></div>
                            
                            <form method="POST" action="{{ route('register') }}" class="mt-4">
                                @csrf

                                <div class="form-group mb-3">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Entrez votre Nom">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" placeholder="Entrez votre Prenom">
                                    @error('prenom')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Entrez votre Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Entrez votre mot de passe">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre mot de passe">
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-register w-100">
                                        S'inscrire
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="login-link">Se Connecter</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
