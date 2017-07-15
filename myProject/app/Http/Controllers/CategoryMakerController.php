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
    $cm_array = $request->cate_maker;
    for ($i=0; $i <count($cm_array) ; $i++) {
      //$request->cate_makerが"1-1","3-10"のような "カテゴリーID-メーカーID" で渡させるのでそれぞれに分解する
      list($category_id, $maker_id) = explode('-', $cm_array[$i]);
      $category_maker = new CategoryMaker();
      $category_maker->category_id  = $category_id;
      $category_maker->maker_id     = $maker_id;
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
    $checks = array(); //viewに渡す配列
    //最終的に下記のような配列でわたるようにする
    // ex.
    // $checks = array(
    //   '0'=>array(
    //     'name'=>'maker_name',    //メーカー名
    //     'val'=>array(            //value値
    //       '0'=>'1-1',
    //       '1'=>'1-2',
    //       '2'=>'1-3'
    //     ),
    //     'check'=>array(           //value値が選択されているかどうか
    //       '0'=>'checked',
    //       '1'=>'',
    //       '2'=>'checked'
    //     )
    //   ),
    //   '1'=>array(
    //     'name'=>'maker_name2',
    //      ....
    //   )
    // )
    //メーカー名とvalue値の配列を生成する処理
    for ($i=0; $i < count($makers) ; $i++) {
      $checks[$i]['name'] = $makers[$i]->name;
      for ($j=0; $j < count($categories) ; $j++) {
        $checks[$i]['val'][]  = $categories[$j]->id."-".$makers[$i]->id;
      }
    }

    //$categories_makersオブジェクトの値から選択された状態(ターゲット)の値の整形,"カテゴリーID-メーカーID"の形にする
    $targetVal =array();
    for ($i=0; $i < count($categories_makers); $i++) {
      $targetVal[] = $categories_makers[$i]->category_id."-".$categories_makers[$i]->maker_id;
    }

    //$checks配列に[check]の連想配列を追加する
    for ($i=0; $i < count($makers) ; $i++) {
      for ($j=0; $j < count($categories) ; $j++) {
        if($targetVal){
          for ($k=0; $k < count($targetVal) ; $k++) {
            //value値がターゲット値と一致していたら、checkedを。
            $checks[$i]['check'][$j][] = $checks[$i]['val'][$j] == $targetVal[$k] ? 'checked' : '';
          }
          //[check]の中の配列値を文字列として結合する、ターゲット値があった場合はcheckdとなる。 dd($checks)をimplode前後に設置して値の確認すべし。
          $merge = implode('', $checks[$i]['check'][$j]);
          $checks[$i]['check'][$j] = $merge;
        }
        else{
          $checks[$i]['check'][$j][] = '';
          //[check]の中の配列値を文字列として結合する、ターゲット値があった場合はcheckdとなる。 dd($checks)をimplode前後に設置して値の確認すべし。
          $merge = implode('', $checks[$i]['check'][$j]);
          $checks[$i]['check'][$j] = $merge;
        }
      }
    }
    return view('category_maker.edit', ['checks'=>$checks, 'categories'=>$categories]);
  }

  public function update(Request $request){
    //dd($request);
    //@TODO $request バリデーション
    $dbCatesMakers = DB::table('category_makers')
                      ->where('status', '<>', 'X')
                      ->get();
    $oldCatesMakers  = array();
    for ($i=0; $i < count($dbCatesMakers); $i++) {
      $oldCatesMakers[] = $dbCatesMakers[$i]->category_id."-".$dbCatesMakers[$i]->maker_id;
    }
    $newCatesMakers = array();
    $newCatesMakers = $request->cate_maker;
    if($newCatesMakers){
      //新規追加分のリレーション
      //追加分の差分値を取得
      $addDiffs = array_diff($newCatesMakers, $oldCatesMakers);
      $addDiffVals = array_values($addDiffs);
      //新規登録処理
      for ($i=0; $i <count($addDiffVals) ; $i++) {
        list($category_id, $maker_id) = explode('-', $addDiffVals[$i]);
        //レコードが存在しているかどうかの確認
        $category_maker = CategoryMaker::where('category_id', '=', $category_id)
                                  ->where('maker_id', '=', $maker_id)
                                  ->where('status', '=', 'X')
                                  ->first();
        if($category_maker){
          //存在していたらステータスの変更
          $category_maker->status       = '◯';
          $category_maker->updter       = $request->cm_updter;
          $category_maker->save();
        }
        else{
          //していなかったら新規生成
          $category_maker = new CategoryMaker();
          $category_maker->category_id  = $category_id;
          $category_maker->maker_id     = $maker_id;
          $category_maker->status       = $request->cm_status;
          $category_maker->rgster       = $request->cm_rgster;
          $category_maker->updter       = $request->cm_updter;
          $category_maker->save();
        }
      }
      //減少分のリレーション
      //追加分の差分値を取得
      $rmvDiffs = array_diff($oldCatesMakers, $newCatesMakers);
      $rmvDiffVals = array_values($rmvDiffs);
      for ($i=0; $i <count($rmvDiffVals) ; $i++) {
        list($category_id, $maker_id) = explode('-', $rmvDiffVals[$i]);
        $category_maker = CategoryMaker::where('category_id', '=', $category_id)
                                        ->where('maker_id', '=', $maker_id)
                                        ->where('status', '<>', 'X')
                                        ->first();
        $category_maker->status       = 'X';
        $category_maker->updter       = $request->cm_updter;
        $category_maker->save();
      }
    }

    return redirect('/categories_makers');
  }
}
