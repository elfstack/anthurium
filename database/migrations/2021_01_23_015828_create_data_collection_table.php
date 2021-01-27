<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id');
            $table->string('purpose');
            $table->boolean('is_re_submittable')->default(false); // allow resubmit
            $table->boolean('is_closed')->default(false);  // do not accept response if closed
            $table->boolean('is_archived')->default(false);
            $table->foreignId('activity_id')->nullable();
            $table->string('activity_stage')->nullable();
            $table->dateTime('available_to')->nullable();
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
        Schema::dropIfExists('FormReferences');
    }
}
