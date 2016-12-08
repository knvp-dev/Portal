<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoitemPromoorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoitem_promoorder', function (Blueprint $table) {
            $table->integer('promoitem_id')->unsigned()->nullable();
            $table->foreign('promoitem_id')->references('id')
            ->on('promo_items')->onDelete('cascade');

              $table->integer('promoorder_id')->unsigned()->nullable();
              $table->foreign('promoorder_id')->references('id')
                    ->on('promo_orders')->onDelete('cascade');

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
        Schema::dropIfExists('promoitem_promoorder');
    }
}
