<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('company');
            $table->string('address');
            $table->integer('postalcode');
            $table->string('city');
            $table->integer('phone');
            $table->integer('fax');
            $table->string('entity');
            $table->string('entity_extra');
            $table->integer('budget')->default(720);
            $table->integer('start_budget')->default(720);
            $table->integer('advertisement_budget')->default(150);
            $table->integer('advertisement_start_budget')->default(150);
            $table->integer('admin')->default(0);
            $table->integer('dm')->nullable();
            $table->integer('dm_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
