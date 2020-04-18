<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoutiqueStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boutique_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('produit_id')->nullable();
			$table->unsignedBigInteger('boutique_id')->nullable();
            $table->unsignedBigInteger('initial')->nullable();
			$table->unsignedBigInteger('valeur')->nullable();
			$table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
			$table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->timestamps();
			$table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boutique_stocks');
    }
}
