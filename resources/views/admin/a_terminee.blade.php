@extends('./layout.admin_app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-danger">Plainte Terminee</h1>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <h3>Liste des plaintes terminées</h3>
        </div>
        <div class="col-auto">
            <a href="#" data-bs-toggle="modal" data-bs-target="#plainteModal" class="btn btn-outline-secondary">
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
                            <th>Reponse</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Boucle pour afficher les plaintes terminées -->
                       @foreach ($plaintes as $plainte)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$plainte->titre}}</td>
                            <td>{{$plainte->description}}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->date)->locale('fr_FR')->isoFormat('DD/MM/YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->heure)->locale('fr_FR')->isoFormat('H:mm') }}</td>
                            <td>{{$plainte->reponse}}</td>
                            <td>
                                <a href="#" class="btn btn-primary view-plainte" data-id="{{$plainte->id}}"><i class="fas fa-eye"></i></a>
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

<!-- Modal pour afficher les détails de la plainte -->
<div class="modal fade" id="viewPlainteModal" tabindex="-1" aria-labelledby="viewPlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPlainteModalLabel">Détails de la plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Titre:</strong> <span id="plainte-titre"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date de création:</strong> <span id="plainte-date-creation"></span></p>
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
                        <p><strong>Description:</strong></p>
                        <div class="p-3 bg-light rounded" id="plainte-description"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p><strong>Réponse:</strong></p>
                        <div class="p-3 bg-light rounded" id="plainte-reponse"></div>
                    </div>
                </div>
                <div class="row mb-3" id="piece-jointe-container">
                    <div class="col-md-12">
                        <p><strong>Pièce jointe:</strong> <a href="#" id="plainte-piece-jointe" target="_blank">Télécharger</a></p>
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
        // Ajouter des écouteurs d'événements pour les boutons de visualisation
        const viewButtons = document.querySelectorAll('.view-plainte');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plainteId = this.getAttribute('data-id');
                fetchPlainteDetails(plainteId);
            });
        });

        // Fonction pour récupérer les détails de la plainte via AJAX
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
                document.getElementById('plainte-description').textContent = data.plainte.description;
                document.getElementById('plainte-reponse').textContent = data.plainte.reponse || 'Aucune réponse';
                document.getElementById('plainte-date-creation').textContent = data.date_creation;
                
                // Gérer la pièce jointe
                const pieceJointeContainer = document.getElementById('piece-jointe-container');
                const pieceJointeLink = document.getElementById('plainte-piece-jointe');
                
                if (data.plainte.piece_jointe) {
                    pieceJointeContainer.style.display = 'block';
                    pieceJointeLink.href = `/storage/${data.plainte.piece_jointe}`;
                } else {
                    pieceJointeContainer.style.display = 'none';
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