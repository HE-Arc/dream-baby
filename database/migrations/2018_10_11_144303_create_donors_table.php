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
            $table->tinyInteger('skin_color');
            $table->tinyInteger('hair_color');
            $table->string('medical_antecedents');
            $table->string('family_antecedents');
            $table->string('photo_uri')->nullable();
            $table->tinyInteger('civil_status')->nullable();
            $table->tinyInteger('education')->nullable();
            $table->string('judiciary_antecedents')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('bio')->nullable();
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
