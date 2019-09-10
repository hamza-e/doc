<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRendezvousEmpechementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendezvous_empechement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('libelle')->nullable();
            $table->datetime('date_de');
            $table->datetime('date_a');
            $table->unsignedInteger('medecin_id');
            $table->foreign('medecin_id')->references('id')->on('medecins')->onDelete('cascade');
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
        Schema::dropIfExists('rendezvous_empechement');
    }
}
