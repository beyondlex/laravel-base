<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('file_id',64)->comment('文件ID');
            $table->tinyInteger('type')->default(1)->comment('类型：1.图片；2.视频');
            $table->timestamp('s_time')->comment('生效时间')->nullable();
            $table->timestamp('e_time')->comment('失效时间')->nullable();
            $table->integer('duration')->default(0)->comment('时长，单位：秒');
            $table->tinyInteger('device')->default(0)->comment('适用设备: 0.所有； 1.手机端；2.平板端');
            $table->softDeletes();
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
        Schema::dropIfExists('ads');
    }
}
