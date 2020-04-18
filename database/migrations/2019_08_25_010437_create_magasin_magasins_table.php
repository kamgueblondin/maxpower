<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagasinMagasinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magasin_magasins', function (Blueprint $table) {
            $table->unsignedBigInteger('magasin')->nullable();
            $table->unsignedBigInteger('magasin_id')->nullable();
            $table->foreign('magasin')->references('id')->on('magasins')->onDelete('cascade');
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade');
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
        Schema::dropIfExists('magasin_magasins');
    }
}
