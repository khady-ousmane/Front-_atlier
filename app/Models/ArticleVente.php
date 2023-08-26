<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ArticleVenteController;
use App\Models\ArticleVente;




class ArticleVente extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'coutProduction', 'qteStock', 'marge', 'promo',"categorie_id","valeur","reference","prixvente"];

    public function categorie()
        {
            return $this->belongsTo(Categorie::class, 'categorie_id');
        }
    
        // public function destroy($id)
        // {
        //     $articleVente = ArticleVente::find($id);
    
        //     if ($articleVente) {
        //         $articleVente->delete();
        //         return response()->json(['message' => 'Article de vente supprimé avec succès']);
        //     } else {
        //         return response()->json(['message' => 'Article de vente non trouvé'], 404);
        //     }
        // }
    
    }