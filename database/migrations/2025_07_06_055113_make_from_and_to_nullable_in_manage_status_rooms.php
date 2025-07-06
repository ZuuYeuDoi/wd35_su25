<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFromAndToNullableInManageStatusRooms extends Migration
{
    public function up()
    {
        Schema::table('manage_status_rooms', function (Blueprint $table) {
            $table->date('from')->nullable()->change();
            $table->date('to')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('manage_status_rooms', function (Blueprint $table) {
            $table->date('from')->nullable(false)->change();
            $table->date('to')->nullable(false)->change();
        });
    }
}
