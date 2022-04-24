<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClassinOldLessonInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classin_old_lesson_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_id')->comment('课程id');
            $table->string('course_name')->nullable()->comment('课程名称');
            $table->string('lesson_id')->comment('课节id');
            $table->string('class_name')->nullable()->comment('课节名称');
            $table->dateTime('begin_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->string('has_get_download_link')->default('no')->comment('是否已获取下载链接`yes`以获取`no`未获取');
            $table->timestamps();
        });

        DB::statement('alter table `classin_old_lesson_infos` comment"课节表，用于下载视频"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classin_old_lesson_infos');
    }
}
