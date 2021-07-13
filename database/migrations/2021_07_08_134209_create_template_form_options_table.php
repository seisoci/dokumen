<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFormOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('template_form_options', function (Blueprint $table) {
      $table->id();
      $table->foreignId('template_form_id')->constrained('template_forms')->onUpdate('cascade')->onDelete('cascade');
      $table->string('option_text');
      $table->string('option_value');
      $table->tinyInteger('option_selected');
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
    Schema::dropIfExists('template_form_options');
  }
}
