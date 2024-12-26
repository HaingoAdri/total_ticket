<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Priorite;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        $priorites = Priorite::all();
        return view('categorie', compact('categories', 'priorites'));
    }

    public function show($id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        return response()->json($categorie);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:500',
            'description' => 'nullable|string|max:500',
        ]);
        // var_dump($validated);
        $categorie = Categorie::create($validated);
        return redirect()->back();
    }

    // Mettre à jour une catégorie
    public function update(Request $request, $id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:500',
            'description' => 'nullable|string|max:500',
        ]);

        $categorie->update($validated);
        return redirect()->back();
    }

    // Supprimer une catégorie
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return redirect()->route('gestion_categorie');
    }
}
