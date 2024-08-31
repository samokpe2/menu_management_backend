<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenusTableForUuid extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->uuid('id')->change();
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
        });
    }
}