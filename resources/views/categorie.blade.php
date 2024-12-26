@extends("navigation")
@section('title', 'Gestion des catégories et priorités')
@section("section")
<div class="container-fluid">

    <!-- Gestion des catégories -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Gestion des catégories</h5>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal" onclick="resetModal('category')">
                    Ajouter une catégorie
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryList">
                    @foreach($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->nom }}</td>
                            <td>{{ $categorie->description }}</td>
                            <td>
                                <!-- Bouton pour modifier -->
                                <button class="btn btn-warning btn-sm" onclick="editItem({{ $categorie->id }}, '{{ $categorie->nom }}', '{{ $categorie->description }}', 'category')">Modifier</button>

                                <!-- Formulaire de suppression avec méthode DELETE -->
                                <form action="{{ route('categorie_destroy', $categorie->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des priorités -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Gestion des priorités</h5>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal" onclick="resetModal('priority')">
                    Ajouter une priorité
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="priorityList">
                    @foreach($priorites as $priorite)
                        <tr>
                            <td>{{ $priorite->id }}</td>
                            <td>{{ $priorite->nom }}</td>
                            <td>{{ $priorite->description }}</td>
                            <td>
                                <!-- Bouton pour modifier -->
                                <button class="btn btn-warning btn-sm" onclick="editItem({{ $priorite->id }}, '{{ $priorite->nom }}', '{{ $priorite->description }}', 'priority')">Modifier</button>

                                <!-- Formulaire de suppression avec méthode DELETE -->
                                <form action="{{ route('priorite_destroy', $priorite->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal d'ajout / modification (dynamique) -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Ajouter ou Modifier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="itemName" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="itemDescription" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour réinitialiser le modal en fonction du type (catégorie ou priorité)
    function resetModal(type) {
        document.getElementById('modalForm').reset();
        const form = document.getElementById('modalForm');
        if (type === 'category') {
            form.action = "{{ route('categorie_store') }}";
            document.getElementById('addModalLabel').textContent = "Ajouter une catégorie";
        } else {
            form.action = "{{ route('priorite_poste') }}";
            document.getElementById('addModalLabel').textContent = "Ajouter une priorité";
        }
    }

    // Fonction pour pré-remplir le formulaire de modification en fonction de l'élément (catégorie ou priorité)
    function editItem(id, name, description, type) {
        const form = document.getElementById('modalForm');
        const itemName = document.getElementById('itemName');
        const itemDescription = document.getElementById('itemDescription');
        
        if (type === 'category') {
            form.action = `/categories/${id}`;
            document.getElementById('addModalLabel').textContent = "Modifier la catégorie";
        } else {
            form.action = `/priorites/${id}`;
            document.getElementById('addModalLabel').textContent = "Modifier la priorité";
        }
        
        itemName.value = name;
        itemDescription.value = description;

        const modal = new bootstrap.Modal(document.getElementById('addModal'));
        modal.show();
    }
</script>

@endsection
