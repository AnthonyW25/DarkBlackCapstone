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
            $table->integer('expense_id');
            $table->char('description', 100)->default('N/A');
            $table->char('category', 100)->default('N/A');
            $table->integer('amount')->default('0');
            $table->integer('gst')->default('0')->nullable();
            $table->integer('pst')->default('0')->nullable();
            //$table->date('date');
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

