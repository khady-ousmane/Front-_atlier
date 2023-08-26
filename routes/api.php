<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ArticleVenteController;

use App\Models\Article;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/categories', [CategorieController::class, 'index']);
Route::post('/categories', [CategorieController::class, 'store']);
Route::put('/categories/{id}', [CategorieController::class, 'update']);
Route::delete('/categories', [CategorieController::class, 'destroy']);

Route::get('/categories/{search}', [CategorieController::class, 'search']);
Route::get('/categories/paginate/{perPage}', [CategorieController::class, 'paginateCategories']);

Route::post('/articles',[ArticleController::class,'store']);
Route::put('/articles/{id}',[ArticleController::class,'update']);
// Route::get('/fournisseur',[FournisseurController::class,'index']);
Route::get('/fournisseurs/recherche', [FournisseurController::class, 'rechercherFournisseurs']);

Route::get('categories-articles-fournisseurs', [ArticleController::class, 'getCategoriesArticlesFournisseurs']);

Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);


// Route::post('/article-ventes', [ArticleVenteController::class, 'index']);

// Route::get('articles-vente', [ArticleVenteController::class, '']);

// Route::get('articles-vente/search/{id}', [ArticleVenteController::class, 'show']);

// Route::put('articles-vente/{id}', [ArticleVenteController::class, 'update']);

// Route::delete('articles-vente/{id}', 'Api\ArticleVenteController@destroy');

Route::get('/articles-vente', [ArticleVenteController::class, 'index']); // Utilisation de la méthode index pour ajouter un nouvel article
Route::post('/articles-vente', [ArticleVenteController::class, 'store']);
// Autres routes pour les autres méthodes (show, update, etc.)
Route::get('/articles-vente/{id}', [ArticleVenteController::class, 'show']);
Route::put('/articles-vente/{id}', [ArticleVenteController::class, 'update']);


