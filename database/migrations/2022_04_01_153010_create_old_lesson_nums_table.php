<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOldLessonNumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_lesson_nums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('year')->comment('年');
            $table->integer('month')->comment('月');
            $table->integer('num')->comment('课节数量');
            $table->integer('per_page')->default(100)->comment('每次获取条数');
            $table->integer('total_page')->comment('总页数');
            $table->integer('page')->comment('当前获取的页码');
            $table->timestamps();
        });

        DB::statement('alter table `old_lesson_nums` comment"以往每月课节数量表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_lesson_nums');
    }
}
