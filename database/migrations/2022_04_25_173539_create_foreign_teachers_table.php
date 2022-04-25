<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateForeignTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_teachers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('account')->comment('账号');
            $table->string('eeo_id')->comment('eeo_id');
            $table->string('name')->comment('名称');
            $table->string('eeo_u_id')->comment('eeo_u_id');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('alter table `foreign_teachers` comment "外教表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreigin_teachers');
    }
}
