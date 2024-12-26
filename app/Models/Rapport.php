<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rapport extends Model
{
    use HasFactory;
    protected $table = 'rapport_ticket';
    protected $fillable = ['id','ticket','rapport','date_rapport','created_at','updated_at'];

    // public function getCoureur(){
    //     $result = DB::table("veiw_coureur")->paginate(10);
    //     return $result;
    // }

    // public function getCoureur_Equipe($equipe){
    //     $response = DB::select("select * from veiw_coureur where equipe = $equipe");
    //     return $response;
    // }
}
