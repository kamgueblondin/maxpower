<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldeBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solde_boutiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('boutique_jour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->unsignedBigInteger('facture_boutique_id')->nullable();
            $table->unsignedBigInteger('boutique_stock_id')->nullable();
            $table->unsignedBigInteger('quantite')->nullable();
            $table->decimal('prix', 18, 2)->nullable();
            $table->foreign('boutique_jour_id')->references('id')->on('boutique_jours')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->foreign('facture_boutique_id')->references('id')->on('facture_boutiques')->onDelete('cascade');
            $table->foreign('boutique_stock_id')->references('id')->on('boutique_stocks')->onDelete('cascade');
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
        Schema::dropIfExists('solde_boutiques');
    }
}
