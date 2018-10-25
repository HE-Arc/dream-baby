<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_messages', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('sender_id');
          $table->foreign('sender_id')->references('id')->on('users');
          $table->unsignedInteger('receiver_id');
          $table->foreign('receiver_id')->references('id')->on('users');
          $table->string('message');
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
        Schema::dropIfExists('private_messages');
    }
}
