<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->morphs('participant');
            $table->foreignId('activity_id')->constrained();
            // created at, updated at
            $table->timestamps();
            // if cancelled, i.e. cannot make to
            $table->timestamp('cancelled_at')->nullable();
            // if needs approval
            $table->timestamp('approved_at')->nullable();
            // if rejected
            $table->timestamp('rejected_at')->nullable();
            // arrived at
            $table->timestamp('arrived_at')->nullable();
            // left at
            $table->timestamp('left_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations');
    }
}
