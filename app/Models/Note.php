<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'note_technicien';
    protected $fillable = ['id','ticket','note','date_notation','created_at','updated_at'];
}
