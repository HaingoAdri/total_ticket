@extends("navigation")
@section('title', 'Suivi des tickets')
@section("section")
<div class="container-fluid">

    <!-- Gestion des Tickets -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Suivi des avancements des tickets</h5>
                
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Exemple de Ticket -->
                @foreach($liste as $ticket)
                <div class="col-md-4">
                    <div class="card" style="height:450px">
                        <div class="card-header bg-danger text-white">
                            {{$ticket->categorie}} - (#{{ $ticket->id }})
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$ticket->titre}}</h5>
                            <p><span class="fw-bold">Plaignant :</span> {{$ticket->utilisateur}} ({{$ticket->poste}})</p>
                            <p><span class="fw-bold">Description :</span> {{$ticket->description}}</p>
                            <p><span class="fw-bold">Priorité :</span> {{$ticket->priorite}}</p>
                            <p><span class="fw-bold">Deadline :</span> {{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}</p>
                            
                            @if(is_numeric($ticket->etat))
                                <p><span class="fw-bold">Évolution :</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $ticket->etat }}%" aria-valuenow="{{ $ticket->etat }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $ticket->etat }}%
                                    </div>
                                </div>
                            @else
                                <p><span class="fw-bold">Etat de traitement : {{ $ticket->etat }}</span></p>
                            @endif

                            <br>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ticketModal" 
                                    onclick="voirDetails('{{ $ticket->id }}', '{{ $ticket->titre }}', '{{ $ticket->description }}','{{ $ticket->utilisateur }}','{{ $ticket->poste }}' ,
                                                          '{{ $ticket->etat }}', '{{ \Carbon\Carbon::parse($ticket->date_creation)->format('d/m/Y à H:i\h') }}',
                                                          '{{ \Carbon\Carbon::parse($ticket->date_resolution)->format('d/m/Y à H:i\h') }}', 
                                                          '{{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}', '{{ $ticket->categorie }}')">
                                Voir Détails
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Modal pour afficher les détails du ticket et modifier l'état -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">Détails du ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateTicketForm" action="{{ route('ticket.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="modalTicketId" name="ticket_id">
                    <input type="hidden" id="modalCurrentDate" name="current_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}">

                    <p><strong>Titre :</strong> <span id="modalTitre"></span></p>
                    <p><strong>Description :</strong> <span id="modalDescription"></span></p>

                    <!-- État du ticket -->
                    <div id="modalEtatContainer">
                        <!-- Le contenu ici sera déterminé en fonction de l'état -->
                    </div>
                    <br>
                    <p><strong>Plaignant :</strong> <span id="modalUser"></span> (<span id="modalPoste"></span>)</p>
                    <p><strong>Date de création :</strong> <span id="modalDateCreation"></span></p>
                    <p><strong>Deadline :</strong> <span id="modalDeadline"></span></p>
                    <p><strong>Mise à jour :</strong> <span id="modalResolution"></span></p>
                    <p><strong>Catégorie :</strong> <span id="modalCategorie"></span></p>

                    <!-- Sélection de l'état pour modification -->
                    <p><strong>Modifier l'état :</strong></p>
                    <select id="etatSelect" name="etat_id" class="form-select">
                        @foreach($liste_etat as $etat)
                            <option value="{{$etat->id}}">{{$etat->nom}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" form="updateTicketForm" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>


<script>
    function voirDetails(id, titre, description,utilisateur,poste, etat, dateCreation,dateresolution, deadline, categorie) {
    // Remplir les informations dans le modal
    document.getElementById('modalTitre').innerText = titre;
    document.getElementById('modalDescription').innerText = description;
    document.getElementById('modalUser').innerText = utilisateur;
    document.getElementById('modalPoste').innerText = poste;
    document.getElementById('modalDateCreation').innerText = dateCreation;
    document.getElementById('modalResolution').innerText = dateresolution;
    document.getElementById('modalDeadline').innerText = deadline;
    document.getElementById('modalCategorie').innerText = categorie;

    // Remplir l'ID du ticket dans le champ caché
    document.getElementById('modalTicketId').value = id;

    // Vérifier si l'état est un nombre (pour afficher la barre de progression)
    var modalEtatContainer = document.getElementById('modalEtatContainer');
    if (isNumeric(etat)) {
        modalEtatContainer.innerHTML = `
            <p><span class="fw-bold">Évolution :</span></p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: ${etat}%" aria-valuenow="${etat}" aria-valuemin="0" aria-valuemax="100">
                    ${etat}%
                </div>
            </div>
        `;
    } else {
        modalEtatContainer.innerHTML = `
            <p><span class="fw-bold">Etat de traitement : ${etat}</span></p>
        `;
    }

    // Remplir la sélection de l'état actuel
    document.getElementById('etatSelect').value = etat;
}

// Fonction utilitaire pour vérifier si un état est un nombre
function isNumeric(value) {
    return !isNaN(value) && value !== '';
}

</script>

@endsection
