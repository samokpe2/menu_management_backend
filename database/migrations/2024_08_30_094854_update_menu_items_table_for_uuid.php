<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuItemsTableForUuid extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('menu_id')->change();
            $table->uuid('parent_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('parent_id')->nullable()->change();
        });
    }
}