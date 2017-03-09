<?php

namespace App\Http\Controllers;

use App\Repositories\PromoOrderRepository;
use Illuminate\Http\Request;
use Auth;

class PromoOrderController extends Controller
{

    protected $order;

    public function __construct(PromoOrderRepository $order){
        $this->order = $order;
    }

    public function index()
    {
        return $this->order->getForUser();
    }

    public function store(Request $request)
    {
        $this->order->create($request);

        return "created";
    }

    public function show($id)
    {
        if(Auth::id() == $this->order->findById($id)->user_id || Auth::user()->isAdmin() || Auth::user()->isDm()){
            return view('pages.promomateriaal.detail')->with('id',$id);
        }
        return redirect('/');
    }

    public function getOrderDetail($id){
        return $this->order->findById($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $this->order->remove($id);
    }

    public function getAll(){
        return $this->order->getAll();
    }

    public function getAllByStatus($status){
        return $this->order->getAllByStatus($status);
    }

    public function getByStatus($status){
        return $this->order->getByStatus($status);
    }

}
