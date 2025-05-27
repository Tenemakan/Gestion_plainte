<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Plaintes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <section class="banner py-5 position-relative text-white banner-enhanced">
        <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100"></div>
        <div class="banner-particles position-absolute top-0 start-0 w-100 h-100"></div>
        <div class="container position-relative z-1">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="banner-title-wrapper mb-3">
                        <h1 class="display-4 fw-bold mb-0 text-uppercase banner-title">Nous gérons vos plaintes</h1>
                        <div class="banner-underline mx-auto mt-2"></div>
                    </div>
                    <p class="lead mb-4 banner-subtitle">Efficacement et dans les plus brefs délais</p>
                    
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="feature-card d-flex align-items-center justify-content-center">
                                <span class="feature-icon rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="feature-text">Traitement rapide</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="feature-card d-flex align-items-center justify-content-center">
                                <span class="feature-icon rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="feature-text">Suivi personnalisé</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card d-flex align-items-center justify-content-center">
                                <span class="feature-icon rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="feature-text">Solutions efficaces</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="banner-buttons d-flex flex-column flex-md-row justify-content-center gap-3">
                        <a href="{{ route ('login') }}" class="btn-primary btn-lg px-4 py-3">POSEZ VOTRE PLAINTE MAINTENANT !<span class="arrow ms-2">→</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="Contact py-5" id="contact">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="section-title mb-4">CONTACT</h2>
                        <div class="title-underline mx-auto mb-4"></div>
                        <p class="contact-text mb-5">Vous avez une question, une suggestion ou besoin d'assistance ? N'hésitez pas à nous écrire, nous serons ravis de vous répondre dans les plus brefs délais.</p>
                        
                        <div class="row justify-content-center contact-info">
                            <div class="col-md-5 mb-4 mb-md-0">
                                <div class="contact-item">
                                    <div class="contact-icon mb-3">
                                        <i class="fas fa-phone-alt fa-2x"></i>
                                    </div>
                                    <p class="contact-detail">+225 <span class="phone-number">0101010101</span>0</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="contact-item">
                                    <div class="contact-icon mb-3">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <p class="contact-detail">plainte.@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Gestion de Plaintes. Tous droits réservés.</p>
    </footer>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>