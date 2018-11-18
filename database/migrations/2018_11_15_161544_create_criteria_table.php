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
        Schema::create('criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('criteria');
    }
}
