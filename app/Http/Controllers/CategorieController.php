<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenericValidationRequest;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Http\Resources\ResourceCategorie;

class CategorieController extends Controller
{
    public function index(){
    $categorie=Categorie::all();
    return $categorie;


    
    }
    public function paginateCategories( $perPage )
    {
        $categories = Categorie::paginate($perPage);
        return ResourceCategorie::collection($categories);
    }
    public function store(Request $request)
    {
        $categorie = Categorie::create($request->all());
        $updatedCategories = Categorie:: where('libelle',$categorie)->orderBy('created_at', 'desc')->get();
    
        return response()->json([
            'message' => 'Catégorie ajoutée avec succès.',
            'categories' => $updatedCategories,
        ]);
    }
    
    

    public function update(Request $request, $id)
{
    $categorie = Categorie::findOrFail($id);
    
    $request->validate([
        'libelle' => 'required|string|max:255',
    ]);
    
    $newLibelle = $request->input('libelle');
    $existingCategorie = Categorie::where('libelle', $newLibelle)->where('id', '!=', $id)->first();

    if ($existingCategorie) {
        return response()->json(['exists' => true, 'message' => 'Le libellé existe déjà.'], 400);
    }
    
    $categorie->libelle = $newLibelle;
    $categorie->save();
    
    return response()->json([
        'message' => 'Libellé de la catégorie mis à jour avec succès.',
        'categorie' => $categorie,
    ]);
}


    public function destroy(Request $request) {
        $this->validate($request, [
            'ids' => 'required|array',        ]);
    
        $errors = [];
    
        foreach ($request->ids as $id) {
            $categorie = Categorie::find($id);
    
            if (!$categorie) {
                $errors[] = "La catégorie ID $id n'existe pas";
                continue;
            }
    
            $categorie->delete();
        }
    
        if (count($errors) > 0) {
            return response()->json(['errors' => $errors], 422);
        }
    
        return response()->json([
            'message' => 'Catégories supprimées'
        ], 200);
    }
    
    public function search(string $recher)
    {
        $categorie = Categorie::where("libelle", $recher)->first();
        $exists = $categorie ? true : false;
        
        return response()->json([
            'exists' => $exists
        ]);
    }
    
}
