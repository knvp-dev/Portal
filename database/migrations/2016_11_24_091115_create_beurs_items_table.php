<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeursItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beurs_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('name_nl')->unique();
            $table->string('name_fr')->unique();
            $table->integer('unavailability_id');
            $table->string('image');
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
        Schema::dropIfExists('beurs_items');
    }
}
