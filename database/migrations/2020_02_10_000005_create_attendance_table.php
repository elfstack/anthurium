<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'attendance';

    /**
     * Run the migrations.
     * @table attendance
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('arrived_at');
            $table->timestamp('left_at')->nullable()->default(null);
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');

            $table->index(["user_id", "activity_id"]);

            $table->foreign('activity_id')
                ->references('id')->on('activities')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
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
