<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('venteconfig', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('articleVente_id');
            $table->unsignedBigInteger('article_id');
            $table->integer('qte');
            $table->timestamps();

            $table->foreign('articleVente_id')->references('id')->on('article_ventes');
            $table->foreign('articleConfection_id')->references('id')->on('article_confections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vente_confections');
    }

};