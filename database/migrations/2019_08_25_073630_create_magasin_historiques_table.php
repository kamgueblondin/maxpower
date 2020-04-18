<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagasinHistoriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magasin_historiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('magasin_jour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('magasin_id')->nullable();
            $table->string('entite')->nullable();
            $table->text('description')->nullable();
            $table->foreign('magasin_jour_id')->references('id')->on('magasin_jours')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade');
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
        Schema::dropIfExists('magasin_historiques');
    }
}
