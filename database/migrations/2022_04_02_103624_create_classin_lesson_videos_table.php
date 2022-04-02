<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClassinLessonVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classin_lesson_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_id')->comment('课程id');
            $table->string('lesson_id')->comment('课节id');
            $table->string('course_name')->nullable()->comment('课程名称');
            $table->string('class_name')->nullable()->comment('课节名称');
            $table->dateTime('begin_time')->comment('开始时间');
            $table->string('url')->comment('视频链接');
            $table->string('has_download')->default('no')->comment('是否下载`yes`是`no`否');
            $table->timestamps();
        });

        DB::statement('alter table `classin_lesson_videos` comment "classin课节视频链接表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classin_lesson_videos');
    }
}
