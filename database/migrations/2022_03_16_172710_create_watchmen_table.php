<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWatchmenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watchmen', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->date('date')->comment('日期');
            $table->bigInteger('user_id')->comment('用户id');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('alter table `watchmen` comment"值班人员表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watchmen');
    }
}
