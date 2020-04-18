<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagasinStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magasin_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('produit_id')->nullable();
			$table->unsignedBigInteger('magasin_id')->nullable();
            $table->unsignedBigInteger('initial')->nullable();
			$table->unsignedBigInteger('valeur')->nullable();
			$table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
			$table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade');
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
        Schema::dropIfExists('magasin_stocks');
    }
}
