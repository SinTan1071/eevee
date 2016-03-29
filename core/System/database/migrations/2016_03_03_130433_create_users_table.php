<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('username')->unique();
        $table->string('mail',255)->unique();
        $table->string('role',30);
        $table->string('status',30);
        $table->string('avatar');
        $table->string('password', 32);
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
