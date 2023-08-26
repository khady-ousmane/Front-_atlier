<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticleVente;

class ArticleVenteController extends Controller
{
    

    public function index()
    {
        $articlesVente = ArticleVente::paginate(10); // Vous pouvez ajuster le nombre d'articles par page selon vos besoins

        return response()->json($articlesVente);
    }

    public function store(Request $request)
    {
        // Validez les données entrées par l'utilisateur si nécessaire
        $validatedData = $request->validate([
            'libelle' => 'required|string',
            'coutProduction' => 'required|numeric',
            'qteStock' => 'required|integer',
            'marge' => 'required|numeric',
            'promo' => 'nullable|string',
            'categorie_id' => 'required|integer',
            'valeur' => 'required|numeric',
            'reference' => 'nullable|string',
            'photo' => 'nullable|string',
            'prixvente' => 'required|numeric',
            

        ]);

        return response()->json(['message' => 'insertion réussit'], 404);

        // Créez un nouvel article de vente en utilisant les données validées
        $articleVente = ArticleVente::create($validatedData);

        return response()->json($articleVente, 201); // Réponse avec le nouvel article et code de statut 201 (Created)
    }


    public function show($id)
    {
        $articleVente = ArticleVente::find($id);

        if ($articleVente) {
            return response()->json($articleVente);
        } else {
            return response()->json(['message' => 'Article de vente non trouvé'], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $articleVente = ArticleVente::find($id);

        if ($articleVente) {
            // Valider les données entrées par l'utilisateur si nécessaire
            $validatedData = $request->validate([
                'libelle' => 'required|string',
                'coutProduction' => 'required|numeric',
                'qteStock' => 'required|integer',
                'marge' => 'required|numeric',
                'promo' => 'nullable|string',
                'categorie_id' => 'required|integer',
                'valeur' => 'required|numeric',
                'reference' => 'nullable|string',
                'photo' => 'nullable|string',
                'prixvente' => 'required|numeric',
    
            ]);

            $articleVente->update($validatedData);

            return response()->json($articleVente, 200); // Réponse avec l'article modifié et code de statut 200 (OK)
        } else {
            return response()->json(['message' => 'Article de vente non trouvé'], 404);
        }
    }

}