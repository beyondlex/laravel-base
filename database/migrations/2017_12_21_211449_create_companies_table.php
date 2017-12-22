<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('pid', 36)->nullable();
            $table->string('code', 20);
            $table->string('name', 99);
            $table->string('phone', 20)->nullable();
            $table->string('address', 256)->nullable();
            $table->string('logo', 256)->nullable();
            $table->string('area_code', 20)->nullable();
            $table->string('province', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('district', 20)->nullable();
            $table->string('contact_name', 10)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->tinyInteger('contact_gender')->nullable();
            $table->string('contact_role', 20)->nullable();
            $table->string('contact_email', 50)->nullable();
            $table->boolean('status')->default(1);
            $table->string('scale', 20)->nullable();
            $table->string('industry', 30)->nullable();
            $table->string('log_file_id', 36)->nullable();
            $table->tinyInteger('reg_from')->nullable();
            $table->string('reg_by', 36)->nullable();
            $table->integer('channel')->nullable();
            $table->string('sales_email', 50)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
