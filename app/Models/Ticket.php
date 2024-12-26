<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'ticket';
    protected $fillable = ['id','titre','description','etat','date_creation','date_deadline','date_debut_activite','date_resolution','categorie','priorite','technicien','utilisateur','created_at','updated_at'];

    public function createId()
    {
        $sequenceName = 'seq_ticket_id';
        $prefix = 'T';
        $numZeros = 4;

        $response = DB::select('SELECT generate_custom_id(?, ?, ?) AS id', [
            $sequenceName,
            $prefix,
            $numZeros
        ]);

        // Retourne l'identifiant généré
        return $response[0]->id;
    }
}
