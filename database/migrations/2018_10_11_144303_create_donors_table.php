<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('sex');
            $table->tinyInteger('eye_color');
            $table->foreign('eye_color')->references('id')->on('eye_colors');
            $table->tinyInteger('ethnicity');
            $table->foreign('ethnicity')->references('id')->on('ethnicities');
            $table->tinyInteger('hair_color');
            $table->foreign('hair_color')->references('id')->on('hair_colors');
            $table->string('medical_antecedents');
            $table->string('family_antecedents');
            $table->string('photo_uri')->default('defaultuser.png');
            $table->date('birth_date')->nullable();
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
        Schema::dropIfExists('donors');
    }
}
