<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteTechnicienController extends Controller
{
    // Lister toutes les notes des techniciens
    public function index()
    {
        $notes = Note::all();
        return response()->json($notes);
    }

    // Afficher une note spécifique
    public function show($id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note non trouvée'], 404);
        }
        return response()->json($note);
    }

    // Créer une nouvelle note
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket' => 'required|string|exists:ticket,id',
            'note' => 'required|integer|min:1|max:5',
            'date_notation' => 'required|date',
        ]);

        $note = Note::create($validated);
        return response()->json($note, 201);
    }

    // Mettre à jour une note
    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note non trouvée'], 404);
        }

        $validated = $request->validate([
            'ticket' => 'sometimes|required|string|exists:ticket,id',
            'note' => 'sometimes|required|integer|min:1|max:5',
            'date_notation' => 'sometimes|required|date',
        ]);

        $note->update($validated);
        return response()->json($note);
    }

    // Supprimer une note
    public function destroy($id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note non trouvée'], 404);
        }

        $note->delete();
        return response()->json(['message' => 'Note supprimée avec succès']);
    }
}
