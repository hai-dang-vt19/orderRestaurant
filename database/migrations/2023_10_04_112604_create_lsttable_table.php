<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLsttableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lsttable', function (Blueprint $table) {
            $table->integer('id_table')->primary();
            $table->integer('member');
            $table->string('des')->nullable();
            $table->integer('status')->define(0);
            $table->integer('id_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lsttable');
    }
}
