<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{

    private $tableName = 'budgets';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('budget_category_id')->nullable();
            $table->decimal('budget');
            $table->decimal('expense');
            $table->string('name');
            $table->timestamps();

            $table->foreign('budget_category_id')
                ->references('id')->on('budget_categories')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('activity_id')
                ->references('id')->on('activities')
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
