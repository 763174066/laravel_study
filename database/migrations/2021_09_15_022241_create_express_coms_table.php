<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressComsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_coms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('快递公司名称');
            $table->string('com')->nullable()->comment('快递公司代码');
            $table->enum('is_use',['0','1'])->comment('是否启用，1启用。0未启用');
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
        Schema::dropIfExists('express_coms');
    }
}
