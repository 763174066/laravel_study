<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassinSubscribeMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classin_subscribe_msgs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ClassId')->comment('课节ID');
            $table->bigInteger('ActionTime')->comment('动作时间戳');
            $table->bigInteger('TargetUID')->nullable()->comment('目标用户ID，0 表示没有目标人，实际目标是教室所有用户');
            $table->bigInteger('SourceUID')->nullable()->comment('发起用户ID，0 表示没有发起人，是服务产生的消息');
            $table->bigInteger('CourseID')->comment('课程ID');
            $table->bigInteger('TimeStamp')->comment('机构认证时间戳');
            $table->string('Cmd')->comment('消息类型');
            $table->bigInteger('Identity')->nullable()->comment('用户身份 1：学生，2：旁听，3：老师，4：助教，193：机构校长，194：校长助理');
            $table->string('_id')->comment('消息标识');
            $table->bigInteger('StartTime')->nullable()->comment('课节开始时间');
            $table->bigInteger('CloseTime')->nullable()->comment('课节关闭时间');
            $table->bigInteger('SID')->comment('触发设备检测的用户ID');
            $table->bigInteger('UID')->comment('机构ID');
            $table->string('SafeKey')->comment('机构认证安全密钥md5(SECRET + TimeStamp)');
            $table->json('data')->comment('信息详情');
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
        Schema::dropIfExists('classin_subscribe_msgs');
    }
}
