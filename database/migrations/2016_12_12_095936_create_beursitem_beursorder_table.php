<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeursitemBeursorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beursitem_beursorder', function (Blueprint $table) {
            $table->integer('beursitem_id')->unsigned()->nullable();
            $table->foreign('beursitem_id')->references('id')
            ->on('beurs_items')->onDelete('cascade');

              $table->integer('beursorder_id')->unsigned()->nullable();
              $table->foreign('beursorder_id')->references('id')
                    ->on('beurs_orders')->onDelete('cascade');

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
        Schema::dropIfExists('beursitem_beursorder');
    }
}
