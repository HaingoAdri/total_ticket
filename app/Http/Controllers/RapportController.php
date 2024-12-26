<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapport;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    public function index()
    {
        return response()->json(Rapport::all());
    }

    public function show($id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }
        return response()->json($rapport);
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'ticket_id' => 'required|exists:ticket,id',  // Vérifier que le ticket existe
            'rapport' => 'required|string|max:1500',  // Limite de caractères pour le rapport
            'current_date' => 'required|date',  // La date du rapport
        ]);
        DB::update("UPDATE ticket SET etat = ? WHERE id = ?", [4, $validated['ticket_id']]);
        // Création du rapport et enregistrement dans la base de données
        $rapport = Rapport::create([
            'ticket' => $validated['ticket_id'],
            'rapport' => $validated['rapport'],
            'date_rapport' => $validated['current_date'],
        ]);

        // Retourner une réponse JSON
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }

        $validated = $request->validate([
            '' => 'sometimes|required|string|exists:,id',
            'rapport' => 'sometimes|required|string|max:1500',
            'date_rapport' => 'sometimes|required|date',
        ]);

        $rapport->update($validated);
        return response()->json($rapport);
    }

    public function destroy($id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }

        $rapport->delete();
        return response()->json(['message' => 'Rapport supprimé avec succès']);
    }
}
