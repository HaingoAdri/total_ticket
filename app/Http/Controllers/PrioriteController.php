<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priorite;

class PrioriteController extends Controller
{
    public function index()
    {
        return response()->json(Priorite::all());
    }

    public function show($id)
    {
        $priorite = Priorite::find($id);
        if (!$priorite) {
            return response()->json(['message' => 'Priorité non trouvée'], 404);
        }
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:500',
            'description' => 'nullable|string|max:500',
        ]);
        Priorite::create($validated);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $priorite = Priorite::find($id);
        if (!$priorite) {
            return response()->json(['message' => 'Priorité non trouvée'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:500',
            'description' => 'nullable|string|max:500',
        ]);

        $priorite->update($validated);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $priorite = Priorite::find($id);
        if (!$priorite) {
            return redirect()->back()->with('error', 'Priorite non trouve');
        }

        $priorite->delete();
        return redirect()->back();
    }
}
