<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKantooritemKantoororderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantooritem_kantoororder', function (Blueprint $table) {
            $table->integer('kantooritem_id')->unsigned()->nullable();
            $table->foreign('kantooritem_id')->references('id')
            ->on('kantoor_items')->onDelete('cascade');

              $table->integer('kantoororder_id')->unsigned()->nullable();
              $table->foreign('kantoororder_id')->references('id')
                    ->on('kantoor_orders')->onDelete('cascade');

            $table->integer('amount')->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('kantooritem_kantoororder');
    }
}
