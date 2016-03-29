<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->string('ident');
            $table->string('name');
            $table->string('resource_ident');
            $table->string('type');
            $table->string('source');
            $table->primary('ident');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
