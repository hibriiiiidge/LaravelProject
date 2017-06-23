<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemCategory;
use App\ItemMaker;
use App\CategoryMaker;
use Illuminate\Support\Facades\DB;

class ItemMakerApiController extends Controller
{
  public function index(Request $request){
    //$category = ItemCategory::findOrFail($request->categoryId);
    //@TODO 本当は下記のような感じでmakersを取得したい
    //リレーションの設定で、item_category_item_maker_tableというテーブルが必要
    //現在の中間テーブルは、category_makers_tableである。
    //$makers = $category->item_makers;
    $makers = DB::table('category_makers AS CM')
                ->select('CM.maker_id AS id', 'IM.name AS name')
                ->leftJoin('item_makers AS IM', 'IM.id', '=', 'CM.maker_id')
                ->where('CM.category_id', '=', $request->categoryId)
                ->where('IM.status', '<>', 'X')
                ->where('CM.status', '<>', 'X')
                ->get();
    return response($makers);
  }
}
