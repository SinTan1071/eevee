<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('access_tokens', function (Blueprint $table) {
          $table->string('access_token');
          $table->integer('user_id');
          $table->string('client');
          $table->primary('access_token');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('access_tokens');
    }
}
