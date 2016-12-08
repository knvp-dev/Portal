<?php 

namespace App\Repositories\Contracts;

interface OrderInterface{
	public function getAll();
	public function findById($id);
	public function getForUser();
	public function create($items);
	public function remove($id);
}