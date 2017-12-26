<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->string('id', 36);
			$table->string('company_id', 36);
			$table->string('department_id', 36)->nullable();
            $table->string('role_id', 36)->nullable();
            $table->string('phone', 20)->unique();
            $table->string('email', 50)->nullable();
            $table->string('password', 64);
            $table->string('confirm_password', 64)->nullable();
            $table->boolean('status')->default(1);

            $table->dateTime('last_login')->nullable();
            $table->boolean('send_sms')->default(0);
            $table->boolean('send_email')->default(0);
            $table->string('face_tokens', 256)->nullable();
            $table->boolean('face_status')->default(0);

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
        Schema::dropIfExists('staff');
    }
}
