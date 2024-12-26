<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reouverture extends Model
{
    use HasFactory;
    protected $table = 'reouverture';
    protected $fillable = ['id','ticket','raison','date_reouverture','created_at','updated_at'];
}
