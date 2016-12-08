<?php 

use App\PromoItem;
use App\Repositories\PromoMateriaalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PromoItemTest extends TestCase{

	use DatabaseTransactions;

	/** @test **/
	function can_add_to_stock(){
		$promoitem = $this->getPromoItem();
		$stock = $promoitem->stock;
		$repo = $this->getRepo();
		$updatedPromoItem = $repo->AddToStock($promoitem->code,10);
		$this->assertEquals($stock, ($updatedPromoItem->stock - 10));
	}

	/** @test **/
	function can_subtract_from_stock(){
		$promoitem = $this->getPromoItem();
		$stock = $promoitem->stock;
		$repo = $this->getRepo();
		$updatedPromoItem = $repo->subtractFromStock($promoitem->code,10);
		$this->assertEquals($stock, ($updatedPromoItem->stock + 10));
	}

	/** @test **/
	function can_deplete_item_stock(){
		$promoitem = $this->getPromoItem();
		$repo = $this->getRepo();
		$updatedPromoItem = $repo->depleteStock($promoitem->code);
		$this->assertEquals($updatedPromoItem->stock, 0);
	}

	public function getRepo(){
		return new PromoMateriaalRepository();
	}

	public function getPromoItem(){
		return PromoItem::whereCode(9781000000184)->first();
	}

}