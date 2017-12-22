<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('departments', function(Blueprint $table) {
      // These columns are needed for Baum's Nested Set implementation to work.
      // Column names may be changed, but they *must* all exist and be modified
      // in the model.
      // Take a look at the model scaffold comments for details.
      // We add indexes on parent_id, lft, rgt columns by default.
//      $table->increments('id');
      $table->string('id', 36);
      $table->string('parent_id', 36)->nullable()->index();
      $table->integer('lft')->nullable()->index();
      $table->integer('rgt')->nullable()->index();

      // Add needed columns here (f.ex: name, slug, path, etc.)
       $table->string('name', 255);
       $table->string('company_id', 36);

       $table->softDeletes();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('departments');
  }

}
