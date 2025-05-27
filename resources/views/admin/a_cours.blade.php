@extends('./layout.admin_app')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-danger">Plainte en cours</h1>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <h3>Liste des plaintes en cours</h3>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Boucle pour afficher les plaintes en cours -->
                       @foreach ($plaintes as $plainte)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$plainte->titre}}</td>
                            <td>{{$plainte->description}}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->date)->locale('fr_FR')->isoFormat('DD/MM/YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plainte->heure)->locale('fr_FR')->isoFormat('H:mm') }}</td>
                            <td>
                                <a href="#" class="btn btn-primary view-plainte" data-id="{{$plainte->id}}"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-success repondre-plainte" data-id="{{$plainte->id}}"><i class="fas fa-check-circle"></i></a>
                                <a href="#" class="btn btn-danger refuser-plainte" data-bs-toggle="modal" data-bs-target="#refuserPlainteModal" data-id="{{$plainte->id}}"><i class="fas fa-times-circle"></i></a>
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
<div class="modal fade" id="detailPlainteModal" tabindex="-1" aria-labelledby="detailPlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailPlainteModalLabel">Détails de la plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Titre:</h5>
                        <p id="plainte-titre" class="fw-bold"></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5>Date de soumission:</h5>
                        <p id="plainte-date-creation"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h5>Description:</h5>
                        <p id="plainte-description" class="border p-3 bg-light"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Déposée par:</h5>
                        <p id="plainte-user"></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Pièce jointe:</h5>
                        <p id="plainte-piece-jointe"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <a href="#" id="btn-repondre" class="btn action-btn">Répondre</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour répondre à une plainte -->
<div class="modal fade" id="repondrePlainteModal" tabindex="-1" aria-labelledby="repondrePlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="repondrePlainteModalLabel">Répondre à la plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="repondreForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <h5>Titre de la plainte:</h5>
                        <p id="repondre-plainte-titre" class="fw-bold"></p>
                    </div>
                    <div class="mb-3">
                        <h5>Description:</h5>
                        <p id="repondre-plainte-description" class="border p-3 bg-light"></p>
                    </div>
                    <div class="mb-3">
                        <label for="reponse" class="form-label">Votre réponse</label>
                        <textarea class="form-control" id="reponse" name="reponse" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut de la plainte</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="statut-terminee" value="terminee" checked>
                            <label class="form-check-label" for="statut-terminee">
                                Terminée (Acceptée)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statut" id="statut-refusee" value="refusee">
                            <label class="form-check-label" for="statut-refusee">
                                Refusée
                            </label>
                        </div>
                    </div>
                    <div class="mb-3" id="motif-refus-container" style="display: none;">
                        <label for="motif_refus" class="form-label">Motif du refus</label>
                        <textarea class="form-control" id="motif_refus" name="motif_refus" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Envoyer la réponse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour refuser une plainte -->
<div class="modal fade" id="refuserPlainteModal" tabindex="-1" aria-labelledby="refuserPlainteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="refuserPlainteModalLabel">Refuser la plainte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="refuserForm" action="" method="POST" onsubmit="return validateRefuserForm()">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <h5>Titre de la plainte:</h5>
                        <p id="refuser-plainte-titre" class="fw-bold"></p>
                    </div>
                    <div class="mb-3">
                        <label for="motif_refus_direct" class="form-label">Motif du refus <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="motif_refus_direct" name="motif_refus" rows="4" required></textarea>
                        <div class="form-text">Veuillez expliquer clairement les raisons du refus de cette plainte.</div>
                    </div>
                    <input type="hidden" name="statut" value="refusee">
                    <input type="hidden" name="plainte_id" id="refuser_plainte_id">
                    <input type="hidden" name="reponse" value="Plainte refusée">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le refus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fonction pour valider le formulaire de refus
    function validateRefuserForm() {
        const motifRefus = document.getElementById('motif_refus_direct').value.trim();
        if (motifRefus === '') {
            alert('Veuillez saisir un motif de refus.');
            return false;
        }
        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Gestionnaire d'événement pour les boutons "Répondre"
        const repondreButtons = document.querySelectorAll('.repondre-plainte');
        repondreButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plainteId = this.getAttribute('data-id');
                
                // Requête AJAX pour récupérer les détails de la plainte
                fetch(`/plainte/show/${plainteId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Remplir le modal avec les données
                    document.getElementById('repondre-plainte-titre').textContent = data.plainte.titre;
                    document.getElementById('repondre-plainte-description').textContent = data.plainte.description;
                    
                    // Configurer le formulaire
                    document.getElementById('repondreForm').action = `/admin/plainte/update-reponse/${data.plainte.id}`;
                    
                    // Afficher le modal
                    const modal = new bootstrap.Modal(document.getElementById('repondrePlainteModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails:', error);
                    alert('Erreur lors de la récupération des détails de la plainte.');
                });
            });
        });
        
        // Afficher/masquer le champ motif de refus en fonction du statut sélectionné
        document.querySelectorAll('input[name="statut"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const motifRefusContainer = document.getElementById('motif-refus-container');
                if (this.value === 'refusee') {
                    motifRefusContainer.style.display = 'block';
                    document.getElementById('motif_refus').setAttribute('required', 'required');
                } else {
                    motifRefusContainer.style.display = 'none';
                    document.getElementById('motif_refus').removeAttribute('required');
                }
            });
        });
        
        // Gestionnaire d'événement pour les boutons "Refuser"
        const refuserButtons = document.querySelectorAll('.refuser-plainte');
        refuserButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plainteId = this.getAttribute('data-id');
                
                // Requête AJAX pour récupérer les détails de la plainte
                fetch(`/plainte/show/${plainteId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Remplir le modal avec les données
                    document.getElementById('refuser-plainte-titre').textContent = data.plainte.titre;
                    
                    // Configurer le formulaire
                    document.getElementById('refuserForm').action = `/admin/plainte/update-reponse/${data.plainte.id}`;
                    document.getElementById('refuser_plainte_id').value = data.plainte.id;
                    
                    // Réinitialiser le champ de motif de refus
                    document.getElementById('motif_refus_direct').value = '';
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails:', error);
                    alert('Erreur lors de la récupération des détails de la plainte.');
                });
            });
        });
        
        // Gestionnaire d'événement pour les boutons "Voir"
        const viewButtons = document.querySelectorAll('.view-plainte');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plainteId = this.getAttribute('data-id');
                
                // Requête AJAX pour récupérer les détails de la plainte
                fetch(`/plainte/show/${plainteId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Remplir le modal avec les données
                    document.getElementById('plainte-titre').textContent = data.plainte.titre;
                    document.getElementById('plainte-description').textContent = data.plainte.description;
                    document.getElementById('plainte-date-creation').textContent = data.date_creation;
                    document.getElementById('plainte-user').textContent = data.plainte.user.name;
                    
                    // Gestion de la pièce jointe
                    const pieceJointeElement = document.getElementById('plainte-piece-jointe');
                    if (data.plainte.piece_jointe) {
                        pieceJointeElement.innerHTML = `<a href="/storage/${data.plainte.piece_jointe}" target="_blank" class="btn btn-sm btn-info">Télécharger</a>`;
                    } else {
                        pieceJointeElement.textContent = 'Aucune pièce jointe';
                    }
                    
                    // Configurer le bouton de réponse
                    document.getElementById('btn-repondre').href = `/admin/plainte/repondre/${data.plainte.id}`;
                    
                    // Afficher le modal
                    const modal = new bootstrap.Modal(document.getElementById('detailPlainteModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails:', error);
                    alert('Erreur lors de la récupération des détails de la plainte.');
                });
            });
        });
    });
</script>

@endsection
