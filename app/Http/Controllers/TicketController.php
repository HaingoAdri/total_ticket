<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use App\Models\Categorie;
use App\Models\Priorite;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    public function index($id)
    {
        $liste = DB::select("select * from ticket_details where id_utilisateur = '$id'");
        $categories = Categorie::all();
        return view('gestion_ticket', compact('liste', 'categories'));
    }

    public function assignation()
    {
        $liste = DB::select("SELECT * FROM ticket_details WHERE technicien is null");
        $priorites = Priorite::all();
        return view('assignation', compact('liste','priorites'));
    }

    public function suivi($id){
        $liste = DB::select("SELECT * FROM ticket_details WHERE id_technicien = '$id'");
        $liste_etat = DB::select('select * from etat where id >4');
        return view('suivi_technicien', compact('liste', 'liste_etat'));
    }

    public function suivi_client($id){
        $liste = DB::select("SELECT * FROM ticket_details WHERE id_utilisateur = '$id'");
        return view('suivi_user', compact('liste'));
    }

    public function rapport($id){
        $liste = DB::select("SELECT * FROM ticket_details WHERE id_technicien = '$id' and etat='100'");
        return view('rapport', compact('liste'));
    }

    public function update(Request $request)
    {
        // Validation des données
        $request->validate([
            'ticket_id' => 'required|exists:ticket,id',
            'etat_id' => 'required|exists:etat,id', // Vérifie que l'état existe
            'current_date' => 'required|date',
        ]);

        DB::table('ticket')
            ->where('id', $request->ticket_id)
            ->update([
                'etat' =>$request->etat_id,
                'date_resolution' => $request->current_date,
            ]);
        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'État du ticket mis à jour avec succès.');
    }


    public function assigner_technicien(Request $request)
    {
        $allTickets = $request->input('all_tickets', []);
        $selectedTickets = $request->input('tickets', []);
        $priorites = $request->input('priorites', []);
        $utilisateur = 'EMP0002';
        $date = Carbon::now()->toDateTimeString();
        foreach ($allTickets as $ticketId) {
            $isSelected = in_array($ticketId, $selectedTickets);
            $priorite = $priorites[$ticketId] ?? null;

            if ($isSelected) {
                DB::table('ticket')
                    ->where('id', $ticketId)
                    ->update([
                        'technicien' =>$utilisateur,
                        'priorite' => $priorite,
                        'etat'=>5,
                        'date_debut_activite'=>$date,
                    ]);
            }
        }

        return redirect()->back();
    }

    // public function 

    public function store(Request $request)
    {
        $id = (new Ticket())->createId();
        $titre = $request->input('title');
        $description = $request->input('description');
        $categorie = $request->input('category_id');
        $date_depot = Carbon::now()->toDateTimeString(); // Date actuelle en format 'Y-m-d H:i:s'
        $utilisateur = "EMP0002";
        
        // Assurez-vous que deadline est bien dans le bon format 'Y-m-d H:i:s'
        $deadline = Carbon::parse($request->input('deadline'))->toDateTimeString(); 

        Ticket::create([
            'id' => $id,
            'titre' => $titre,
            'description' => $description,
            'categorie' => $categorie,
            'etat'=>2,
            'utilisateur' => $utilisateur, 
            'date_creation' => $date_depot,  // Utilisation du format 'Y-m-d H:i:s'
            'date_deadline' => $deadline   // Format 'Y-m-d H:i:s'
        ]);

        return redirect()->back();
    }


    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->back()->with('message','Ticket non trouvé');
        }

        $ticket->delete();
        return redirect()->back()->with('message', 'Ticket supprimé avec succès');
    }
}
