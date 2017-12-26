<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('username', 60);
            $table->string('password', 64);
            $table->string('company_id', 36)->nullable();
			$table->string('name', 60)->nullable();
			$table->string('telephone', 60)->nullable();
			$table->string('email', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('remark', 255)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->boolean('wizarded')->nullable()->default(0);

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
        Schema::dropIfExists('managers');
    }
}
