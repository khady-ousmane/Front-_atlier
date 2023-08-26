<?php

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignIdFor(Categorie::class)->constrained()->cascadeOnDelete();
            $table->integer('quantite');
            $table->integer('prix');
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            $table->text('reference');
            $table->text('photo');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};