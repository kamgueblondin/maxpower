<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersementBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versement_boutiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('boutique_jour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->string('destination')->nullable();
            $table->decimal('montant', 18, 2)->nullable();
            $table->text('description')->nullable();
            $table->foreign('boutique_jour_id')->references('id')->on('boutique_jours')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
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
        Schema::dropIfExists('versement_boutiques');
    }
}
