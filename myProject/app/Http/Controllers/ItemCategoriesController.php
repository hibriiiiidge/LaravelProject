<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemCategory;
use Illuminate\Support\Facades\DB;

class ItemCategoriesController extends Controller
{
  public function index(){
    $item_categories = DB::table('item_categories')
                        ->orderBy('status', 'asc')
                        ->get();
    return view('item_category.index',[
        'item_categories' => $item_categories,
    ]);
  }

  public function create(){
    $item_category = new ItemCategory();
    return view('item_category.register', ['item_category' => $item_category]);
  }

  public function store(Request $request){
    //dd($request);
    //@TODO $request バリデーション
    $item_category = new ItemCategory();
    $item_category->name     = $request->ic_name;
    $item_category->status   = $request->ic_status;
    $item_category->rgster   = $request->ic_rgster;
    $item_category->updter   = $request->ic_updter;
    $item_category->save();
    $item_categories = DB::table('item_categories')
                      ->orderBy('status', 'asc')
                      ->orderBy('id', 'asc')
                      ->get();
    return redirect('/item_categories');
  }

  public function edit($itemCategoryId){
    $item_category = ItemCategory::findOrFail($itemCategoryId);
    return view('item_category.edit', ['item_category' => $item_category]);
  }

  public function update(Request $request, $itemCategoryId){
    //dd($request);
    //@TODO $request バリデーション
    $item_category = ItemCategory::findOrFail($itemCategoryId);
    $item_category->name         = $request->ic_name;
    $item_category->status       = $request->ic_status;
    $item_category->updter       = $request->ic_updter;
    $item_category->save();
    $item_categories = DB::table('item_categories')
                          ->orderBy('status', 'asc')
                          ->orderBy('id', 'asc')
                          ->get();
    return redirect('/item_categories');
  }
}
