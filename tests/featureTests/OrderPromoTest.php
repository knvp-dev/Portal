<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderPromoTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    function a_user_can_place_an_order(){
    	$this->signIn();

    	$promoitem = create('App\PromoItem');
    	$promoitem2 = create('App\PromoItem');

    	$order = [
    		'orderitems' => [
    			'product' => $promoitem,
    			'product' => $promoitem2,
    		],
    		'totalPrice' => 1254
    	];

    	$this->post('/promomateriaal/order/create', $order);

    	$this->assertEquals(1, \App\PromoOrder::all()->count());
    }

    /** @test */
    function a_user_can_cancel_an_order(){
    	$this->signIn();

    	$order = create('App\PromoOrder');

    	$this->get('/promomateriaal/order/delete/' . $order->id);

    	$this->assertEquals(0, \App\PromoOrder::all()->count());
    }

}
