<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'participants';

    /**
     * Run the migrations.
     * @table participants
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('enrolled_at');

            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('attendance_id')->nullable();

            $table->index(['activity_id', 'user_id']);

            $table->foreign('activity_id')
                ->references('id')->on('activities')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('attendance_id')
                ->references('id')->on('attendance')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
