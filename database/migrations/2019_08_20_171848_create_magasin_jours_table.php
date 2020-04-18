<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagasinJoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magasin_jours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('magasin_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
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
        Schema::dropIfExists('magasin_jours');
    }
}
