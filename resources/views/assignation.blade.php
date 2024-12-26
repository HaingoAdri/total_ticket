@extends("navigation")
@section('title', 'Assignation des tickets')
@section("section")
<div class="container-fluid">

    <!-- Gestion des Tickets -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Assignation de tickets</h5>
            </div>
        </div>
        <div class="card-body">
        <form action="{{ route('assigner_technicien') }}" method="post">
                @csrf
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Ticket</th>
                        <th>Priorité</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($liste as $ticket)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" name="tickets[]" value="{{ $ticket->id }}">
                                <input type="hidden" name="all_tickets[]" value="{{ $ticket->id }}"> <!-- Ajout de l'input hidden -->
                            </td>
                            <td>
                                {{ $ticket->titre }} ({{ $ticket->id }})<br>
                                <div class="d-flex justify-content-end">
                                    <button 
                                        type="button"
                                        class="btn btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#ticketModal"
                                        onclick="voirDetails(
                                            '{{ $ticket->titre }}',
                                            '{{ $ticket->description }}',
                                            '{{ $ticket->etat }}',
                                            '{{ \Carbon\Carbon::parse($ticket->date_creation)->format('d/m/Y à H:i') }}',
                                            '{{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i') }}',
                                            '{{ $ticket->categorie }}'
                                        )">
                                        Voir Détails
                                    </button>
                                </div>
                            </td>
                            <td>
                                <select name="priorites[{{ $ticket->id }}]" class="form-select">
                                    @foreach($priorites as $priorite)
                                        <option value="{{ $priorite->id }}">{{ $priorite->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <input type="submit" value="Assignés" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour afficher les détails -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Détails du ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Titre :</strong> <span id="modalTitre"></span></p>
                    <p><strong>Description :</strong> <span id="modalDescription"></span></p>
                    <p><strong>État :</strong> <span id="modalEtat"></span></p>
                    <p><strong>Date de création :</strong> <span id="modalDateCreation"></span></p>
                    <p><strong>Deadline :</strong> <span id="modalDeadline"></span></p>
                    <p><strong>Catégorie :</strong> <span id="modalCategorie"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function voirDetails(titre, description, etat, dateCreation, deadline, categorie) {
        document.getElementById('modalTitre').innerText = titre;
        document.getElementById('modalDescription').innerText = description;
        document.getElementById('modalEtat').innerText = etat;
        document.getElementById('modalDateCreation').innerText = dateCreation;
        document.getElementById('modalDeadline').innerText = deadline;
        document.getElementById('modalCategorie').innerText = categorie;
    }
</script>

@endsection
