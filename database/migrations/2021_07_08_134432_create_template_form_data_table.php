<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFormDataTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('template_form_data', function (Blueprint $table) {
      $table->id();
      $table->foreignId('template_data_id')->constrained('template_data')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('template_form_option_id')->constrained('template_form_options')->onUpdate('cascade')->onDelete('cascade');
      $table->string('value');
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
    Schema::dropIfExists('template_form_data');
  }
}
