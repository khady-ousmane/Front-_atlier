<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Fournisarticles;
use App\Models\Fournisseur;

class ArticleController extends Controller
{
    public function index()
    {
    }

    public function show($id)
    {
        // code
    }

    public function store(Request $request)
    {
               $request->validate([
                'libelle' => 'required|string|min:3',
                'categorie_id' => 'required|exists:categories,id',
                'photo' => 'required|max:2048', // Ajout de la règle mimes pour les extensions
                'fournisseurs' => 'array',
                'fournisseurs.*' => 'exists:fournisseurs,id',
                'prix' => 'required|numeric|min:1', // Ajout de la règle min pour le prix
                'quantite' => 'required|numeric|min:1', // Ajout de la règle min pour la quantité
            ]);
            
            $photo = $request->input('photo');
            $libelle = $request->input('libelle');
            $categorie = Categorie::findOrFail($request->input('categorie_id'));
            $selectedFournisseurs = $request->input('fournisseurs');
            $numero_ordre = Article::where('categorie_id', $categorie->id)->count() + 1;
            $prix = $request->input('prix');
            $stock = $request->input('quantite');
            $reference = 'REF-' . strtoupper(substr($libelle, 0, 3)) . '-' . strtoupper(($categorie->libelle)) . '-' . $numero_ordre;
            // dd($reference);
            if (Article::where(['libelle' => $libelle, 'categorie_id' => $categorie->id,])->exists()) {
                return response()->json([
                    'message' => 'Une ligne avec la même référence existe déjà.',
                    'error' => true,
                ], 400);
            }
            // dd($stock);
            // $photoPath = null; // Initialisez la variable en dehors de la condition
            $article = new Article([
                'libelle' => $libelle,
                'reference' => $reference,
                'categorie_id' => $categorie->id,
                'prix' => $prix,
                'quantite' => $stock,
                'photo' =>  $photo
            ]);
            $article->save();
            // foreach ($selectedFournisseurs as $fournisseurId) {
            //     $articleFourni = new Fournisarticles([
            //         'article_id' => $article->id,
            //         'fournisseur_id' => $fournisseurId
            //     ]);

            //     $articleFourni->save();
            // }
            return response()->json([
                'message' => 'Article créé avec succès',
                'article' => $article,
                'fournisarticle' => $selectedFournisseurs,
                'photo' => $photo,
            ], 201);
    }

    public function getCategoriesArticlesFournisseurs()
    {
        $categories = Categorie::all();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();

        return response()->json([
            'categories' => $categories,
            'articles' => $articles,
            'fournisseurs' => $fournisseurs,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $request->validate([
                'libelle' => 'required|string|min:3',
                'categorie_id' => 'required|exists:categories,id',
                'fournisseurs' => 'array',
                'fournisseurs.*' => 'exists:fournisseurs,id',
                'prix' => 'required|numeric',
                'quantite' => 'required|numeric',
            ]);

            $libelle = $request->input('libelle');
            $categorie = Categorie::findOrFail($request->input('categorie_id'));
            $selectedFournisseurs = $request->input('fournisseurs');
            $prix = $request->input('prix');
            $stock = $request->input('quantite');
            $article->libelle = $libelle;
            $article->categorie_id = $categorie->id;
            $article->prix = $prix;
            $article->quantite = $stock;
            // Gérez la mise à jour de la photo si nécessaire
            // ...
            if ($request->hasFile('photo')) {
                // Supprimez l'ancienne photo du serveur si elle existe
                if ($article->photo) {
                    // ... Code pour supprimer l'ancienne photo
                }
                // Enregistrez la nouvelle photo et mettez à jour l'attribut 'photo'
                $newPhotoPath = $request->file('photo')->store('photos');
                $article->photo = $newPhotoPath;
            }
            $article->save();
            // Supprimez d'abord les relations existantes avec les fournisseurs
            $article->fournisseurs()->detach();
            // Ajoutez les nouvelles relations avec les fournisseurs sélectionnés
            foreach ($selectedFournisseurs as $fournisseurId) {
                $article->fournisseurs()->attach($fournisseurId);
            }

            return response()->json([
                'message' => 'Article mis à jour avec succès',
                'article' => $article,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de l\'article', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            // Effectuer d'autres validations ou logiques si nécessaire
            $article->delete();
            return response()->json([
                'message' => 'Article deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting the article',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    //
}
