<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('user_id', 'schedules_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('room_id', 'schedules_ibfk_5')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('handler_1', 'schedules_ibfk_6')->references('id')->on('handlers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('handler_2', 'schedules_ibfk_7')->references('id')->on('handlers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('handler_3', 'schedules_ibfk_8')->references('id')->on('handlers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign('schedules_ibfk_1');
            $table->dropForeign('schedules_ibfk_5');
            $table->dropForeign('schedules_ibfk_6');
            $table->dropForeign('schedules_ibfk_7');
            $table->dropForeign('schedules_ibfk_8');
        });
    }
}
