<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EthnicityCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ethnicity_criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seeker_id');
            $table->unsignedInteger('ethnicity');
            $table->boolean('searched');
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
        Schema::dropIfExists('ethnicity_criterias');
    }
}
