<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResoucesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
          $table->string('ident');
          $table->string('name');
          $table->string('parent');
          $table->string('source');
          $table->primary('ident');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('resources');
    }
}
