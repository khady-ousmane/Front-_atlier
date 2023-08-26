<?php

use App\Models\Article;
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
        Schema::create('fournisarticles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fournisseur::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Article::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisarticles');
    }
};
