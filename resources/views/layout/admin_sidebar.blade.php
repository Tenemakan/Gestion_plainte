<div class="sidebar bg-gradient-dark text-white" style="min-height: 100vh; width: 250px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: sticky; top: 0;">
    <div class="p-3 d-flex flex-column h-100">
        <!-- Logo and Title -->
        <div class="d-flex align-items-center mb-4">
            <div class="me-2 logo-container">
                <i class="fas fa-shield-alt text-orange" style="font-size: 1.8rem;"></i>
            </div>
            <h5 class="mb-0 fw-bold">Community<br>Complaints</h5>
        </div>
        
        <hr class="bg-light opacity-25">
        
        <!-- Navigation Menu -->
        <ul class="nav flex-column menu-items">
            <li class="nav-item mb-2">
                <a href="{{ route('admin') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-tachometer-alt text-orange"></i>
                        </div>
                        <span>Accueil</span>
                    </div>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('admin_plainte_en_cours') }}" class="nav-link {{ request()->is('admin_plainte_en_cours') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-hourglass-half text-orange"></i>
                        </div>
                        <span>Plaintes en cours</span>
                    </div>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin_plainte_terminee') }}" class="nav-link {{ request()->is('admin_plainte_terminee') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-check text-orange"></i>
                        </div>
                        <span>Plaintes terminées</span>
                    </div>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin_plainte_refusee') }}" class="nav-link {{ request()->is('admin_plainte_refusee') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-ban text-orange"></i>
                        </div>
                        <span>Plaintes refusées</span>
                    </div>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin_utilisateur') }}" class="nav-link {{ request()->is('admin_utilisateur') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-user-friends text-orange"></i>
                        </div>
                        <span>Utilisateurs</span>
                    </div>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link {{ request()->is('customer-service') ? 'active bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50 hover-white' }}">
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <i class="fas fa-headset text-orange"></i>
                        </div>
                        <span>Service client</span>
                    </div>
                </a>
            </li>
        </ul>
        
        <hr class="bg-light opacity-25 mt-auto">
        
        <!-- User Profile & Logout -->
        <div class="user-section">
            <div class="user-profile p-2 rounded mb-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-2 bg-primary bg-opacity-25">
                        <i class="fas fa-user-circle text-orange"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-white-50">{{ Auth::user()->email }}</small>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('user.profile') }}" class="btn btn-sm btn-outline-light" title="Voir mon profil">
                            <i class="fas fa-user-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <a href="#" 
               class="nav-link text-white-50 hover-white logout-btn"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="d-flex align-items-center">
                    <div class="icon-container me-3">
                        <i class="fas fa-sign-out-alt text-orange"></i>
                    </div>
                    <span>Déconnexion</span>
                </div>
            </a>
            <form id="logout-form" action="#" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<style>
/* Définition de la couleur orange personnalisée */
.text-orange {
    color: #ff8c00 !important;
}

.bg-gradient-dark {
    background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%);
}

.hover-white:hover {
    color: white !important;
    background-color: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.avatar-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.logo-container {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.sidebar .nav-link {
    border-radius: 8px;
    padding: 10px 14px;
    transition: all 0.3s ease;
    margin-bottom: 2px;
}

.icon-container {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background-color: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.nav-link.active .icon-container {
    background-color: rgba(255, 140, 0, 0.3);
}

.nav-link:hover .icon-container {
    transform: translateX(3px);
}

.menu-items .nav-link {
    position: relative;
    overflow: hidden;
}

.menu-items .nav-link::before {
    content: '';
    position: absolute;
    left: -3px;
    top: 0;
    height: 100%;
    width: 3px;
    background-color: #ff8c00;
    opacity: 0;
    transition: all 0.3s ease;
}

.menu-items .nav-link.active::before,
.menu-items .nav-link:hover::before {
    opacity: 1;
}

.user-profile {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.user-profile:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.logout-btn {
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

