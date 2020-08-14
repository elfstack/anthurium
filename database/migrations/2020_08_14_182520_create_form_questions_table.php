<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id');
            $table->unsignedTinyInteger('sequence');
            $table->string('type'); // text, textarea, radio, checkbox
            $table->string('question');
            $table->boolean('is_required');
            $table->unsignedSmallInteger('max_character');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_questions');
    }
}
