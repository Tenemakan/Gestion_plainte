@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-danger">Plainte Refusee {{ $nb_plaintes_refusee }}</h1>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <h3>Liste des plaintes refusées</h3>
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
                            <th>Motif de refus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Boucle pour afficher les plaintes refusées -->
                        @foreach ($plaintes as $plainte)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $plainte->titre }}</td>
                            <td>{{ $plainte->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->date)->locale('fr_FR')->isoFormat('DD/MM/YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->heure)->locale('fr_FR')->isoFormat('H:mm') }}</td>
                            <td>{{ $plainte->motif_refus }}</td>
                            <td>
                                <a href="#" class="text-decoration-none view-plainte" data-bs-toggle="modal" data-bs-target="#detailPlainteModal" data-id="{{ $plainte->id }}">
                                    <i class="fas fa-eye text-primary fs-5"></i>
                                </a>    
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
                        <button type="submit" class="btn action-btn">Soumettre la plainte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour afficher les détails d'une plainte -->
<div class="modal fade" id="detailPlainteModal" tabindex="-1" aria-labelledby="detailPlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="detailPlainteModalLabel">Détails de la plainte refusée</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
                <div id="plainte-details" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 id="plainte-titre" class="fw-bold"></h4>
                            <p class="text-muted">Soumise le <span id="plainte-date-creation"></span></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Date:</strong> <span id="plainte-date"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Heure:</strong> <span id="plainte-heure"></span></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Description:</h5>
                            <p id="plainte-description" class="border p-3 rounded bg-light"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="text-danger">Motif de refus:</h5>
                            <p id="plainte-motif-refus" class="border p-3 rounded bg-light"></p>
                        </div>
                    </div>
                    <div class="row mb-3" id="piece-jointe-container">
                        <div class="col-md-12">
                            <h5>Pièce jointe:</h5>
                            <p id="piece-jointe-info"></p>
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
        // Sélectionner tous les liens avec la classe view-plainte
        const viewLinks = document.querySelectorAll('.view-plainte');
        
        // Ajouter un écouteur d'événement à chaque lien
        viewLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const plainteId = this.getAttribute('data-id');
                
                // Afficher le spinner de chargement
                document.getElementById('loading').style.display = 'block';
                document.getElementById('plainte-details').style.display = 'none';
                
                // Faire une requête AJAX pour récupérer les détails de la plainte
                fetch(`{{ url('/plainte/show/') }}/${plainteId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Masquer le spinner et afficher les détails
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('plainte-details').style.display = 'block';
                    
                    // Remplir les détails de la plainte dans le modal
                    document.getElementById('plainte-titre').textContent = data.plainte.titre;
                    document.getElementById('plainte-date').textContent = data.date_formatee;
                    document.getElementById('plainte-heure').textContent = data.heure_formatee;
                    document.getElementById('plainte-description').textContent = data.plainte.description;
                    document.getElementById('plainte-motif-refus').textContent = data.plainte.motif_refus || 'Non spécifié';
                    document.getElementById('plainte-date-creation').textContent = data.date_creation;
                    
                    // Gestion de la pièce jointe
                    const pieceJointeContainer = document.getElementById('piece-jointe-container');
                    const pieceJointeInfo = document.getElementById('piece-jointe-info');
                    
                    if (data.plainte.piece_jointe) {
                        pieceJointeContainer.style.display = 'block';
                        const fileUrl = `{{ asset('storage') }}/${data.plainte.piece_jointe}`;
                        const fileName = data.plainte.piece_jointe.split('/').pop();
                        pieceJointeInfo.innerHTML = `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Télécharger ${fileName}</a>`;
                    } else {
                        pieceJointeContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails:', error);
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('plainte-details').style.display = 'block';
                    document.getElementById('plainte-details').innerHTML = '<div class="alert alert-danger">Une erreur est survenue lors du chargement des détails de la plainte.</div>';
                });
            });
        });
    });
</script>

@endsection
