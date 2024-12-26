@extends("navigation")
@section('title', 'Gestion des tickets')
@section("section")
<div class="container-fluid">

    <!-- Gestion des Tickets -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Mes tickets</h5>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal" onclick="resetModal()">
                    Créer un ticket
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Exemple de Ticket -->
                @foreach($liste as $ticket)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            {{$ticket->categorie}} - (#{{ $ticket->id }})
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Problème d'écran </h5>
                            <p><span class="fw-bold">Description :</span> {{ $ticket->description }}</p>
                            <p><span class="fw-bold">Création :</span> {{ \Carbon\Carbon::parse($ticket->date_creation)->format('d/m/Y à H:i\h') }}</p>
                            <p><span class="fw-bold">Deadline :</span> {{ \Carbon\Carbon::parse($ticket->date_deadline)->format('d/m/Y à H:i\h') }}</p>
                            <p><span class="fw-bold">Etat de traitement :</span> 
                                @if (is_numeric(str_replace('%', '', $ticket->etat)))
                                    {{ $ticket->etat }}%
                                @else
                                    {{ $ticket->etat }}
                                @endif
                            </p>

                            <br>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Ajoutez ici d'autres tickets en boucle -->
            </div>
        </div>
    </div>

</div>

<!-- Modal de création / modification d'un ticket -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Créer un ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" method="POST" action="{{route('store_ticket')}}">
                    @csrf
                    <!-- <input type="hidden" name="_method" id="formMethod" value="POST"> -->
                    
                    <!-- Titre -->
                    <div class="mb-3">
                        <label for="ticketTitle" class="form-label">Titre du ticket</label>
                        <input type="text" class="form-control" id="ticketTitle" name="title" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="ticketDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="ticketDescription" name="description" rows="3" required></textarea>
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-3">
                        <label for="ticketCategory" class="form-label">Catégorie</label>
                        <select class="form-select" id="ticketCategory" name="category_id" required>
                            <option value="" disabled selected>Choisir une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deadline -->
                    <div class="mb-3">
                        <label for="ticketDeadline" class="form-label">Deadline</label>
                        <input type="datetime-local" class="form-control" id="ticketDeadline" name="deadline" required>
                    </div>

                    <!-- Bouton d'envoi -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Réinitialiser le modal pour un nouveau ticket
    function resetModal() {
        const form = document.getElementById('modalForm');
        form.reset();
        form.action = "/tickets"; // URL pour créer un ticket
        document.getElementById('formMethod').value = "POST"; // Méthode HTTP
        document.getElementById('addModalLabel').textContent = "Créer un ticket";
    }

    // Pré-remplir le modal pour modifier un ticket
    function editTicket(id, title, description, categoryId, deadline) {
        const form = document.getElementById('modalForm');
        form.action = `/tickets/${id}`; // URL pour mettre à jour un ticket
        document.getElementById('formMethod').value = "PUT"; // Méthode HTTP PUT

        // Pré-remplir les champs
        document.getElementById('ticketTitle').value = title;
        document.getElementById('ticketDescription').value = description;
        document.getElementById('ticketCategory').value = categoryId;
        document.getElementById('ticketDeadline').value = deadline;

        // Mettre à jour le titre du modal
        document.getElementById('addModalLabel').textContent = "Modifier le ticket";

        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('addModal'));
        modal.show();
    }
</script>

@endsection
