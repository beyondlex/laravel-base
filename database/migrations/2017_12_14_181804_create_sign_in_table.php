<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_in', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
			$table->integer('user_id')->nullable();
			$table->string('file_id')->nullable();
			$table->dateTime('sign_in_time');
			$table->tinyInteger('sign_in_type')->default(1);
			$table->string('address')->nullable();
			$table->string('position')->nullable();
			$table->text('content')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('sign_in');
    }
}
