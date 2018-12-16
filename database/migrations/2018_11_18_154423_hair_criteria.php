<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HairCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hair_criterias', function (Blueprint $table) {
            $table->increments('id');
<<<<<<< HEAD
            $table->unsignedInteger('seeker_id')->references('id')->on('seekers');
            $table->unsignedInteger('hair_color')->references('id')->on('hair_colors');
=======
            $table->unsignedInteger('seeker_id');
            $table->foreign('seeker_id')->references('id')->on('seekers');
            $table->unsignedInteger('hair_color');
            $table->foreign('hair_color')->references('id')->on('hair_colors');
>>>>>>> 1c33c2ff474fe0eebae4d21dbde3de7b8273f19a
            $table->boolean('searched')->default(true);
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
        Schema::dropIfExists('hair_criterias');
    }
}
