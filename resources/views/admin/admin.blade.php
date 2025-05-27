@extends('./layout.admin_app')
@section('content')
<div class="container-fluid p-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold">DASHBOARD</h1>
        <div style="height: 4px; width: 100px; background-color: #f05454; margin: 0 auto 30px;"></div>
    </div>
    
    <div class="row justify-content">
        <!-- Nouvelle plainte -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-plus-circle fs-1 text-white"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">Nouvelle plainte</h5>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#plainteModal" class="btn action-btn w-75">Déposer <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Plainte en cours -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="status-circle in-progress mb-3">
                        <h1 class="display-4 fw-bold mb-0 text-white">{{ $nb_plaintes_en_cours }}</h1>
                    </div>
                    <h5 class="card-title text-center fw-bold">Plaintes en cours</h5>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="#" class="btn action-btn w-75">Consulter <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Plainte Refusee -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="status-circle rejected mb-3">
                        <h1 class="display-4 fw-bold mb-0 text-white">{{ $nb_plaintes_refusee }}</h1>
                    </div>
                    <h5 class="card-title text-center fw-bold">Plaintes refusées</h5>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="#" class="btn action-btn w-75">Consulter <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Plainte Terminee -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="status-circle completed mb-3">
                        <h1 class="display-4 fw-bold mb-0 text-white">{{ $nb_plaintes_terminee }}</h1>
                    </div>
                    <h5 class="card-title text-center fw-bold">Plaintes terminées</h5>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="#" class="btn action-btn w-75">Consulter <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Total Utilisateur -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 hover-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="status-circle users mb-3">
                        <h1 class="display-4 fw-bold mb-0 text-white">{{ $nb_utilisateurs }}</h1>
                    </div>
                    <h5 class="card-title text-center fw-bold">Total Utilisateurs</h5>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="#" class="btn action-btn w-75">Consulter <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #f05454;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .status-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .in-progress {
        background-color: #3498db;
    }
    
    .completed {
        background-color: #2ecc71;
    }
    
    .rejected {
        background-color: #e74c3c;
    }
    
    .users {
        background-color: #9b59b6;
    }
    
    .action-btn {
        background-color: #f05454;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 8px 15px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background-color: #e03444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Modal pour l'enregistrement des plaintes -->
<div class="modal fade" id="plainteModal" tabindex="-1" aria-labelledby="plainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="plainteModalLabel">Déposer une nouvelle plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('plainte.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre de la plainte</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description détaillée</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="piece_jointe" class="form-label">Pièce jointe (optionnel)</label>
                        <input type="file" class="form-control" id="piece_jointe" name="piece_jointe">
                        <div class="form-text">Formats acceptés: PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn action-btn" >Soumettre la plainte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Add any JavaScript if needed -->
@endsection
