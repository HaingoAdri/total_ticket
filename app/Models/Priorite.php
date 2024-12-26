<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priorite extends Model
{
    use HasFactory;
    protected $table = 'priorite';
    protected $fillable = ['id','nom','description','created_at','updated_at'];
}
