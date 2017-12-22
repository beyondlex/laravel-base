<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->string('id',36);
			$table->string('name', 30);
			$table->string('company_id', 36);
			$table->string('parent_id', 36)->nullable();
			$table->unsignedInteger('lft')->default(0);
			$table->unsignedInteger('rgt')->default(0);
			$table->boolean('readonly')->default(1);
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
        Schema::dropIfExists('levels');
    }
}
