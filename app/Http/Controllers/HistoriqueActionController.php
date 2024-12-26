<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historique;

class HistoriqueActionController extends Controller
{
    public function index()
    {
        return response()->json(Historique::all());
    }

    public function show($id)
    {
        $historique = Historique::find($id);
        if (!$historique) {
            return response()->json(['message' => 'Historique non trouvé'], 404);
        }
        return response()->json($historique);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket' => 'required|string|exists:ticket,id',
            'date_ajout' => 'required|date',
        ]);

        $historique = Historique::create($validated);
        return response()->json($historique, 201);
    }

    public function destroy($id)
    {
        $historique = Historique::find($id);
        if (!$historique) {
            return response()->json(['message' => 'Historique non trouvé'], 404);
        }

        $historique->delete();
        return response()->json(['message' => 'Historique supprimé avec succès']);
    }
}
