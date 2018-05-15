<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpenseItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   Schema::dropIfExists('expense_items');
        Schema::create('expense_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_id')->default('2');
            $table->char('description', 100);
            $table->char('category', 100);
            $table->integer('amount');
            $table->integer('gst');
            $table->integer('pst');
            $table->timestamps();       
        });

//        Schema::table('expense_items', function($table) {
//            $table->foreign('expense_id')->references('id')->on('expenses');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_items');
    }
}

