<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('parent_id')->nullable();
            $table->enum('tag', ['input','select','textarea','checkbox','radio','table','ul','ol','block']);
            $table->enum('type', ['text','number','decimal','file','date','datetime','image','currency','time']);
            $table->string('name', 64)->nullable();
            $table->string('label', 64);
            $table->tinyInteger('multiple');
            $table->tinyInteger('sort_order');
            $table->tinyInteger('is_column_table');
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
        Schema::dropIfExists('template_forms');
    }
}
