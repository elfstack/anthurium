<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'member-application'
            ]);
            $table->foreignId('user_id')->nullable(); // related member
            $table->json('meta');
            $table->timestamp('completed_at')->nullable();
            $table->smallInteger('step')->unsigned()->default(0);
            $table->string('result')->nullable();
            $table->unsignedSmallInteger('chances_left')->default(99);
            $table->boolean('is_terminated')->default(false);
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
        Schema::dropIfExists('actions');
    }
}
