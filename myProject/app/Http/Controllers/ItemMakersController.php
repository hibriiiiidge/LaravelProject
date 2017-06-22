<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemMaker;
use Illuminate\Support\Facades\DB;

class ItemMakersController extends Controller
{
  public function index(){
    $item_makers = DB::table('item_makers')
                        ->orderBy('status', 'asc')
                        ->get();
    return view('item_maker.index',[
        'item_makers' => $item_makers,
    ]);
  }

  public function create(){
    $item_maker = new ItemMaker();
    return view('item_maker.register', ['item_maker' => $item_maker]);
  }

  public function store(Request $request){
    //dd($request);
    //@TODO $request バリデーション
    $item_maker = new ItemMaker();
    $item_maker->name     = $request->ic_name;
    $item_maker->status   = $request->ic_status;
    $item_maker->rgster   = $request->ic_rgster;
    $item_maker->updter   = $request->ic_updter;
    $item_maker->save();
    $item_makers = DB::table('item_makers')
                      ->orderBy('status', 'asc')
                      ->orderBy('id', 'asc')
                      ->get();
    return redirect('/item_makers');
  }

  public function edit($itemmakerId){
    $item_maker = ItemMaker::findOrFail($itemmakerId);
    return view('item_maker.edit', ['item_maker' => $item_maker]);
  }

  public function update(Request $request, $itemMakerId){
    //dd($request);
    //@TODO $request バリデーション
    $item_maker = ItemMaker::findOrFail($itemMakerId);
    $item_maker->name         = $request->ic_name;
    $item_maker->status       = $request->ic_status;
    $item_maker->updter       = $request->ic_updter;
    $item_maker->save();
    $item_makers = DB::table('item_makers')
                          ->orderBy('status', 'asc')
                          ->orderBy('id', 'asc')
                          ->get();
    return redirect('/item_makers');
  }
}
