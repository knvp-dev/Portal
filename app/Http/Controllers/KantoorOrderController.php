<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\KantoorOrderRepository;
use Illuminate\Http\Request;

class KantoorOrderController extends Controller
{

    protected $order;

    public function __construct(KantoorOrderRepository $order){
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->order->getForUser();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->order->create($request);

        return "created";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        if(Auth::id() == $this->order->findById($id)->user_id || Auth::user()->isAdmin() || Auth::user()->isDm()){
            return view('pages.kantoormateriaal.detail')->with('id',$id);
        }
        return redirect('/');
    }

     public function getOrderDetail($id){
        return $this->order->findById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->order->remove($id);
    }

    public function getByStatus($status){
        return $this->order->getByStatus($status);
    }

    public function getAll(){
        return $this->order->getAll();
    }

    public function getAllByStatus($status){
        return $this->order->getAllByStatus($status);
    }
}
