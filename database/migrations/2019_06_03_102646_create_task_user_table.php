<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('users_tasks', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('task_id');
        //     $table->timestamps();
        // });

        Schema::create('task_user', function (Blueprint $table) {
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('completed')->default(0);
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
        // Schema::dropIfExists('users_tasks');
        Schema::dropIfExists('task_user');
    }
}
