<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemMaker;
use App\ItemCategory;
use App\CategoryMaker;
use Illuminate\Support\Facades\DB;

class CategoryMakerController extends Controller
{
  public function index(){
    $categories = DB::table('item_categories')
                    ->where('status', '<>', 'X')
                    ->get();
    $makers     = DB::table('item_makers')
                    ->where('status', '<>', 'X')
                    ->get();
    $categories_makers = DB::table('category_makers')
                          ->where('status', '<>', 'X')
                          ->get();
    return view('category_maker.index', ['categories'=>$categories, 'makers'=>$makers, 'categories_makers'=>$categories_makers]);
  }

  public function create(){
    $category_maker = new CategoryMaker();
    $categories = DB::table('item_categories')
                    ->where('status', '<>', 'X')
                    ->get();
    $makers     = DB::table('item_makers')
                    ->where('status', '<>', 'X')
                    ->get();
    return view('category_maker.register', ['category_maker' => $category_maker, 'categories'=>$categories, 'makers'=>$makers]);
  }

  public function store(Request $request){
    // dd($request);
    $cm_array = $request->cate_maker;
    for ($i=0; $i <count($cm_array) ; $i++) {
      list($category_id, $maker_id) = explode('-', $cm_array[$i]);
      $category_maker = new CategoryMaker();
      $category_maker->category_id  = $category_id;
      $category_maker->maker_id    = $maker_id;
      $category_maker->status       = $request->cm_status;
      $category_maker->rgster       = $request->cm_rgster;
      $category_maker->updter       = $request->cm_updter;
      $category_maker->save();
    }
    return redirect('/categories_makers');
  }

  public function edit(){
    $category_maker = new CategoryMaker();
    $categories = DB::table('item_categories')
                    ->where('status', '<>', 'X')
                    ->get();
    $makers     = DB::table('item_makers')
                    ->where('status', '<>', 'X')
                    ->get();
    $categories_makers = DB::table('category_makers')
                          ->where('status', '<>', 'X')
                          ->get();
    $checks = array();
    for ($i=0; $i < count($makers) ; $i++) {
      $checks[$i]['name'] = $makers[$i]->name;
      for ($j=0; $j < count($categories) ; $j++) {
        $checks[$i]['val'][]  = $categories[$j]->id."-".$makers[$i]->id;
      }
    }

    $targetVal =array();
    for ($i=0; $i < count($categories_makers); $i++) {
      $targetVal[] = $categories_makers[$i]->category_id."-".$categories_makers[$i]->maker_id;
    }

    for ($i=0; $i < count($makers) ; $i++) {
      for ($j=0; $j < count($categories) ; $j++) {
        for ($k=0; $k < count($targetVal) ; $k++) {
          if($checks[$i]['val'][$j] == $targetVal[$k]){
            $checks[$i]['check_ary'][$j][] = 'checked';
          }
          else{
            $checks[$i]['check_ary'][$j][] = '';
          }
        }
        $merge = implode('', $checks[$i]['check_ary'][$j]);
        $checks[$i]['check'][$j] = $merge;
      }
    }
    return view('category_maker.edit', ['checks'=>$checks, 'categories'=>$categories]);
  }
  //
  // public function update(Request $request, $itemMakerId){
  //   //dd($request);
  //   //@TODO $request バリデーション
  //   $item_maker = ItemMaker::findOrFail($itemMakerId);
  //   $item_maker->name         = $request->ic_name;
  //   $item_maker->status       = $request->ic_status;
  //   $item_maker->updter       = $request->ic_updter;
  //   $item_maker->save();
  //   $item_makers = DB::table('item_makers')
  //                         ->orderBy('status', 'asc')
  //                         ->orderBy('id', 'asc')
  //                         ->get();
  //   return redirect('/item_makers');
  // }
}
