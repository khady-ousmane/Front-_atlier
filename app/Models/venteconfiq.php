<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venteconfiq extends Model
{

    use HasFactory;

    protected $fillable = ['articleVente_id', 'articleConfection_id', 'qte'];

    // ... autres propriétés ou méthodes si nécessaires
}
    
