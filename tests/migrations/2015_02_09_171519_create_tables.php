<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function(Blueprint $table) {
      $table->increments('id');
      $table->string('email');
      $table->timestamps();
    });

    Schema::create('post_translations', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('post_id')->unsigned();
      $table->string('name');
      $table->string('locale')->index();

      $table->unique(['post_id','locale']);
      $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('post_translations');
    Schema::drop('posts');
  }

}
