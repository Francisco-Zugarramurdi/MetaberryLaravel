<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tag');

            $table->unsignedBigInteger('ad_id');
            $table->foreign('ad_id')
                ->references('id')
                ->on('ads')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_tags');
    }
}
