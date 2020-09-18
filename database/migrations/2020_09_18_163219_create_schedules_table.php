<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('room_id')->index('room_id');
            $table->integer('handler_1')->index('handler_1');
            $table->integer('handler_2')->index('handler_2');
            $table->integer('handler_3')->index('handler_3');
            $table->integer('user_id')->index('user_id');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('type');
            $table->integer('status');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
