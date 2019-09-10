<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->time('pause_de')->nullable();
            $table->time('pause_a')->nullable();
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
        Schema::dropIfExists('plannings');
    }
}
