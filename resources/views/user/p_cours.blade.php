@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-danger">Plainte en cours {{ $nb_plaintes_en_cours }}</h1>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <h3>Liste des plaintes en cours</h3>
        </div>
        <div class="col-auto">
            <a href="#" data-bs-toggle="modal" data-bs-target="#plainteModal" class="btn action-btn">
                <i class="fas fa-plus"></i> Nouvelle plainte
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Boucle pour afficher les plaintes en cours -->
                        @foreach ($plaintes as $plainte)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $plainte->titre }}</td>
                            <td>{{ $plainte->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->date)->locale('fr_FR')->isoFormat('DD/MM/YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->heure)->locale('fr_FR')->isoFormat('H:mm') }}</td>
                            <td>
                                <a href="javascript:void(0)" class="text-decoration-none view-plainte" data-id="{{ $plainte->id }}">
                                    <i class="fas fa-eye text-primary fs-5"></i>
                                </a>
                                <form action="{{ route('plainte.destroy', $plainte->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette plainte?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fas fa-trash-alt text-danger fs-5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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

<!-- Modal pour afficher les détails d'une plainte -->
<div class="modal fade" id="viewPlainteModal" tabindex="-1" aria-labelledby="viewPlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPlainteModalLabel">Détails de la plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- En-tête avec titre et statut -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h3 id="plainte-titre" class="fw-bold text-primary mb-0"></h3>
                    </div>
                    <div class="col-md-4 text-end">
                        <span id="plainte-statut" class="badge bg-warning fs-6 px-3 py-2">En cours</span>
                    </div>
                </div>
                
                <!-- Carte d'informations -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Date</small>
                                        <span id="plainte-date" class="fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Heure</small>
                                        <span id="plainte-heure" class="fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Créée le</small>
                                        <span id="plainte-created-at" class="fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Description</h5>
                    </div>
                    <div class="card-body">
                        <div id="plainte-description" class="p-3 bg-white border rounded"></div>
                    </div>
                </div>
                
                <!-- Pièce jointe -->
                <div id="piece-jointe-container" class="card border-0 shadow-sm d-none">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>Pièce jointe</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt text-primary fs-2 me-3"></i>
                            <div>
                                <p class="mb-1">Document attaché à cette plainte</p>
                                <a id="piece-jointe-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i> Télécharger le document
                                </a>
                                <a id="piece-jointe-view" href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
                                    <i class="fas fa-eye me-1"></i> Visualiser
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du clic sur l'icône pour voir les détails d'une plainte
        const viewButtons = document.querySelectorAll('.view-plainte');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const plainteId = this.getAttribute('data-id');
                fetchPlainteDetails(plainteId);
            });
        });
        
        // Fonction pour récupérer les détails d'une plainte via AJAX
        function fetchPlainteDetails(id) {
            fetch(`/plainte/show/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Remplir le modal avec les données
                document.getElementById('plainte-titre').textContent = data.plainte.titre;
                document.getElementById('plainte-date').textContent = data.date_formatee;
                document.getElementById('plainte-heure').textContent = data.heure_formatee;
                document.getElementById('plainte-description').innerHTML = data.plainte.description.replace(/\n/g, '<br>');
                document.getElementById('plainte-created-at').textContent = data.date_creation;
                
                // Gestion de la pièce jointe s'il y en a une
                const pieceJointeContainer = document.getElementById('piece-jointe-container');
                const pieceJointeLink = document.getElementById('piece-jointe-link');
                const pieceJointeView = document.getElementById('piece-jointe-view');
                
                if (data.plainte.piece_jointe) {
                    pieceJointeContainer.classList.remove('d-none');
                    const fileUrl = `/storage/${data.plainte.piece_jointe}`;
                    pieceJointeLink.href = fileUrl;
                    pieceJointeView.href = fileUrl;
                    
                    // Détecter le type de fichier pour afficher l'icône appropriée
                    const fileExt = data.plainte.piece_jointe.split('.').pop().toLowerCase();
                    const fileIcon = document.querySelector('#piece-jointe-container .fas.fa-file-alt');
                    
                    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(fileExt)) {
                        fileIcon.className = 'fas fa-file-image text-success fs-2 me-3';
                    } else if (['pdf'].includes(fileExt)) {
                        fileIcon.className = 'fas fa-file-pdf text-danger fs-2 me-3';
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        fileIcon.className = 'fas fa-file-word text-primary fs-2 me-3';
                    } else if (['xls', 'xlsx'].includes(fileExt)) {
                        fileIcon.className = 'fas fa-file-excel text-success fs-2 me-3';
                    } else if (['zip', 'rar', '7z'].includes(fileExt)) {
                        fileIcon.className = 'fas fa-file-archive text-warning fs-2 me-3';
                    }
                } else {
                    pieceJointeContainer.classList.add('d-none');
                }
                
                // Afficher le modal
                const modal = new bootstrap.Modal(document.getElementById('viewPlainteModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails:', error);
                alert('Une erreur est survenue lors de la récupération des détails de la plainte.');
            });
        }
    });
</script>

@endsection
