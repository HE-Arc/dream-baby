<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->increments('id');
<<<<<<< HEAD
            $table->unsignedInteger('seeker_id')->references('id')->on('seekers');;
=======
            $table->unsignedInteger('seeker_id');
            $table->foreign('seeker_id')->references('id')->on('seekers');
>>>>>>> 1c33c2ff474fe0eebae4d21dbde3de7b8273f19a
            $table->tinyInteger('sex');
            $table->date('birth_date_max')->default(Carbon::now()->subYears(40)->format('Y-m-d H:i:s'));
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
        Schema::dropIfExists('criterias');
    }
}
