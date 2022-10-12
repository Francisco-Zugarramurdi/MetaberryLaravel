<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results_points', function (Blueprint $table) {
            $table->id();
            $table->string('point');
            $table->bigInteger('id_results')->unsigned(); 
            $table->bigInteger('id_teams')->unsigned(); 
            $table->bigInteger('id_players')->unsigned(); 
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
        Schema::dropIfExists('results_points');
    }
}
