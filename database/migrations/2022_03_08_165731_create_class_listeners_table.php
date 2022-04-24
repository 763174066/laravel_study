<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassListenersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_listeners', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('lesson_key')->comment('课节key');
            $table->dateTime('start_at')->comment('课节开始时间');
            $table->dateTime('end_at')->comment('课节开始结束');
            $table->json('lesson_info')->comment('监课信息');
            $table->integer('notice_times')->default(0)->comment('提醒次数');
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
        Schema::dropIfExists('class_listeners');
    }
}
