<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortieMagasinBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortie_magasin_boutiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('magasin_jour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->unsignedBigInteger('magasin_id')->nullable();
            $table->unsignedBigInteger('magasin_stock_id')->nullable();
            $table->unsignedBigInteger('quantite')->nullable();
            $table->foreign('magasin_jour_id')->references('id')->on('magasin_jours')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade');
            $table->foreign('magasin_stock_id')->references('id')->on('magasin_stocks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sortie_magasin_boutiques');
    }
}
