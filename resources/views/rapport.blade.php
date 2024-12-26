@extends("navigation")
@section('title', 'Suivi des tickets')
@section("section")
<div class="container-fluid">

    <!-- Gestion des Tickets -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Faire un rapports</h5>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal" onclick="resetModal('category')">
                    Voir rapport
                </button>
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
                            <p><span class="fw-bold">Technicien traitant:</span> {{$ticket->technicien}}</p>
                            <p><span class="fw-bold">Description :</span> {{$ticket->description}}</p>
                            <p><span class="fw-bold">Priorité :</span> {{$ticket->priorite}}</p>
                            <p><span class="fw-bold">Deadline :</span> {{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}</p>
                            <p><span class="fw-bold">Dernière mise à jour :</span> {{ \Carbon\Carbon::parse($ticket->date_resolution)->format('d/m/Y à H:i\h') }}</p>
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
                            <!-- Button pour ouvrir le modal -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ticketModal" onclick="voirDetails('{{$ticket->id}}', '{{$ticket->titre}}', '{{$ticket->technicien}}', '{{$ticket->description}}', '{{$ticket->priorite}}', '{{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}', '{{ \Carbon\Carbon::parse($ticket->date_resolution)->format('d/m/Y à H:i\h') }}')">
                                Créer un rapport
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Modal pour créer un rapport -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">Détails du Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ticketReportForm" method="POST" action="{{ route('rapport.store') }}">
                    @csrf
                    <!-- Champ caché pour l'id du ticket -->
                    <input type="hidden" name="ticket_id" id="modalTicketId">

                    <!-- Informations sur le ticket -->
                    <p><strong>Titre :</strong> <span id="modalTicketTitre"></span></p>
                    <p><strong>Catégorie :</strong> <span id="modalTicketCategorie"></span></p>
                    <p><strong>Technicien :</strong> <span id="modalTicketTechnicien"></span></p>
                    <p><strong>Description :</strong> <span id="modalTicketDescription"></span></p>
                    <p><strong>Priorité :</strong> <span id="modalTicketPriorite"></span></p>
                    <p><strong>Deadline :</strong> <span id="modalTicketDeadline"></span></p>
                    <p><strong>Date de mise à jour :</strong> <span id="modalTicketDateResolution"></span></p>

                    <!-- Évolution -->
                    <div class="mb-3">
                        <label for="modalTicketEvolution" class="form-label">Évolution</label>
                        <div class="progress" id="progressContainer" style="cursor: pointer;" onclick="updateProgress(event)">
                            <div class="progress-bar" id="progressBarModal" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modalTicketCommentaire" class="form-label">Faire un rapport détaillé</label>
                        <div id="modalTicketCommentaire" style="height: 200px;"></div>
                    </div>

                    <input type="hidden" id="modalCurrentDate" name="x" value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}">

                    <!-- Boutons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Soumettre le rapport</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Intégration de Quill -->
<script>
    

    // Fonction pour remplir les informations dans le modal
    function voirDetails(id, titre, technicien, description, priorite, deadline, resolution) {
        document.getElementById('modalTicketId').value = id; 
        document.getElementById('modalTicketTitre').textContent = titre;
        document.getElementById('modalTicketTechnicien').textContent = technicien;
        document.getElementById('modalTicketDescription').textContent = description;
        document.getElementById('modalTicketPriorite').textContent = priorite;
        document.getElementById('modalTicketDeadline').textContent = deadline;
        document.getElementById('modalTicketDateResolution').textContent = resolution;
    }
    var quill = new Quill('#modalTicketCommentaire', {
        theme: 'snow',  // Choisir le thème (snow, bubble)
        modules: {
        toolbar: [
            [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['bold', 'italic', 'underline'],
            [{ 'align': [] }],
            ['link'],
            ['blockquote', 'code-block']
        ]
        }
    });

    document.getElementById('ticketReportForm').addEventListener('submit', function(event) {
        // Empêcher l'envoi par défaut pour ajouter le contenu de Quill
        event.preventDefault();

        // Récupérer le contenu de Quill
        const rapportContent = quill.root.innerHTML;
        // Ajouter le contenu de Quill à un champ caché dans le formulaire
        const rapportField = document.createElement('input');
        rapportField.setAttribute('type', 'hidden');
        rapportField.setAttribute('name', 'rapport');
        rapportField.setAttribute('value', rapportContent);

        // Ajouter le champ caché au formulaire
        this.appendChild(rapportField);

        // Soumettre le formulaire après avoir ajouté le champ rapport
        this.submit();
    });

</script>

@endsection
