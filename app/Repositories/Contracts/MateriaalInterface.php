<?php
namespace App\Repositories\Contracts;

interface MateriaalInterface {
	public function getAll();
	public function findById($id);
	public function findByCode($code);
	public function getAllItemsInStock();
	public function AddToStock($code, $amount);
	public function subtractFromStock($code, $amount);
	public function depleteStock($code);
}