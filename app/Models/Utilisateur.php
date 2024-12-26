<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utilisateur extends Model
{
    use HasFactory;
    protected $table = 'utilisateur';
    protected $fillable = ['id','nom','email','mot_de_passe','role','date_creation','created_at','updated_at'];

    public function createId()
    {
        $sequenceName = 'seq_utilisateur_id';
        $prefix = 'EMP';
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
