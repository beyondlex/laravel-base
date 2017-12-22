<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('id', 36);
			$table->string('staff_id', 36);
			$table->string('name', 20);
			$table->tinyInteger('gender')->nullable();
			$table->string('telephone', 20)->nullable();
			$table->string('telephone_ext', 10)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('remark', 255)->nullable();
			$table->string('avatar', 255)->nullable();
			$table->boolean('visible')->default(1);

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
        Schema::dropIfExists('profiles');
    }
}
