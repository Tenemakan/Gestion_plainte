<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .login-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 50px;
    }
    
    .login-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 20px;
    }
    
    .login-image {
        max-width: 100%;
        height: auto;
    }
    
    .login-form-container {
        padding: 30px;
    }
    
    .login-title {
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .login-title-underline {
        height: 4px;
        width: 100px;
        background-color: #dc3545;
        margin: 0 auto 30px;
    }
    
    .login-btn {
        background-color: #f05454;
        border: none;
        border-radius: 25px;
        padding: 10px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .login-btn:hover {
        background-color: #e03444;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .forgot-password,
    .create-account {
        color: #333;
        text-decoration: none;
    }
    
    .form-control {
        border-radius: 25px;
        padding: 10px 15px;
    }
</style>
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card login-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 login-image-container">
                            <img src="{{ asset('images/login.png') }}" alt="Login" class="login-image">
                        </div>
                        <div class="col-md-6 login-form-container">
                            <h1 class="text-center login-title">CONNEXION</h1>
                            <div class="login-title-underline"></div>
                            
                            <form method="POST" action="{{ route('login') }}" class="mt-4">
                                @csrf
                                
                                <div class="form-group mb-3">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Entrez votre mail">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Entrez votre mot de passe">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary login-btn w-100">
                                        Se Connecter
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <a class="btn btn-link create-account" href="{{ route('register') }}">
                                        Créer un compte
                                    </a>
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