<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user',100);
            $table->string('name', 255)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('username', 100);
            $table->text('password');
            $table->string('phone',12)->nullable();
            $table->integer('roles')->nullable();
            $table->integer('id_area');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
