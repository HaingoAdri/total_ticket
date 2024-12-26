<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;
    protected $table = 'historique_action';
    protected $fillable = ['id','ticket','date_ajout','created_at','updated_at'];
}
