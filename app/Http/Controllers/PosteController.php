<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function index()
    {
        return response()->json(Utilisateur::all());
    }

    public function show($id)
    {
        $utilisateur = Utilisateur::find($id);
        if (!$utilisateur) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        return response()->json($utilisateur);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:20|unique:utilisateur,id',
            'nom' => 'required|string|max:500',
            'email' => 'required|email|max:50',
            'mot_de_passe' => 'required|string|min:6|max:100',
            'role' => 'required|integer|exists:poste,id',
        ]);

        $utilisateur = Utilisateur::create($validated);
        return response()->json($utilisateur, 201);
    }

    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::find($id);
        if (!$utilisateur) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:500',
            'email' => 'sometimes|required|email|max:50',
            'mot_de_passe' => 'nullable|string|min:6|max:100',
            'role' => 'nullable|integer|exists:poste,id',
        ]);

        $utilisateur->update($validated);
        return response()->json($utilisateur);
    }

    public function destroy($id)
    {
        $utilisateur = Utilisateur::find($id);
        if (!$utilisateur) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $utilisateur->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
