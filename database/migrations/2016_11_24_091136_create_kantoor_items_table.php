<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKantoorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantoor_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name_nl')->unique();
            $table->string('name_fr')->unique();
            $table->string('entity');
            $table->integer('pack');
            $table->integer('stock');
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
        Schema::dropIfExists('kantoor_items');
    }
}
