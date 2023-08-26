<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisarticles extends Model
{
    use HasFactory;
    protected $fillable=['article_id','fournisseur_id'];
    protected $hidden=[ "deleted_at","created_at","updated_at"];
}
