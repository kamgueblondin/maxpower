<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAvantInventaireAndApresInventaireToMagasinStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magasin_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('avant_inventaire')->nullable();
            $table->unsignedBigInteger('apres_inventaire')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magasin_stocks', function (Blueprint $table) {
            //
        });
    }
}
