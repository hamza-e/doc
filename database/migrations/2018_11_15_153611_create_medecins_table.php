<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedecinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medecins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe');
            $table->string('image');
            $table->string('adresse');
            $table->text('bio');
            $table->string('telephone');
            $table->string('langues');
            $table->string('city');
            $table->double('tarif_de', 8, 2);
            $table->double('tarif_a', 8, 2);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('specialite_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('cascade');
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
        Schema::dropIfExists('medecins');
    }
}
