<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerInfoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'volunteer_info';

    /**
     * Run the migrations.
     * @table volunteer_info
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('id_number', 40);
            $table->string('alias', 45);
            $table->string('gender', 20);
            $table->date('birthday');
            $table->string('education', 20)->nullable()->default(null);
            $table->string('organisation', 60)->nullable()->default(null);
            $table->string('mobile_number', 20);
            $table->string('address', 128)->nullable()->default(null);
            $table->string('interests', 60)->nullable()->default(null);
            $table->string('emergency_contact', 45)->nullable()->default(null);
            $table->string('volunteer_experences', 255)->nullable()->default(null);
            $table->string('references', 45)->nullable()->default(null);

            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
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
