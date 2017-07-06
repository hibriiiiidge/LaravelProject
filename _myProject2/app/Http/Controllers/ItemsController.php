<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\BaseType;
use App\RequestDetail;
use App\RequestProgress;
use App\Item;
use App\ItemProgress;
use App\User;
use App\ItemCategory;
use App\ItemMaker;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    /**
     *  item_detail一覧表示 登録日時の降順
     */
    public function index(Request $request){
      //検索条件
      if($request->item_id_1 && $request->item_id_2 && $request->item_id_3){
        $item_id    = $request->item_id_1."-".$request->item_id_2."-".$request->item_id_3;
      }
      else{
        $item_id = null;
      }
      $request_id   = $request->request_id;
      $item_name    = $request->item_name;
      $progress     = $request->progress;
      $category_no  = $request->category_no;
      $maker_no     = $request->maker_no;

      $items_results = DB::table('items AS I')
                      ->select(
                        'I.id AS i_id',
                        'I.request_id AS r_id',
                        'RD.client_id AS c_id',
                        'IP_SQ.max_s AS ip_status',
                        'IC.name AS ic_name',
                        'IM.name AS im_name',
                        'I.outside_condition AS o_cond',
                        'I.inside_condition AS i_cond',
                        'I.name AS i_name',
                        'I.buy_price AS buy_price',
                        'I.sell_price AS sell_price',
                        'IP.profit AS profit' ,
                        'IP.profit_rate AS profit_rate',
                        'I.updated_at AS updated_at'
                        )
                      ->leftJoin('item_categories AS IC', 'IC.id', '=', 'I.category')
                      ->leftJoin('item_makers AS IM', 'IM.id', '=', 'I.maker')
                      ->leftJoin('request_details AS RD', 'RD.request_id', '=', 'I.request_id')
                      ->leftJoin(DB::raw("(select id, SUM(buy_price) AS buy_price, SUM(sell_price) AS sell_price, SUM(sell_price)-SUM(buy_price) AS profit, (SUM(sell_price)-SUM(buy_price))/SUM(sell_price)*100 AS profit_rate from items where status <> 'X' group by id) AS IP"), 'IP.id', '=', 'I.id')
                      ->leftJoin(DB::raw("(select request_id, progress_status from request_progresses where (request_id, flow_no) in (select request_id, max(flow_no) from request_progresses group by request_id)) AS RP"), 'RP.request_id', '=', 'I.request_id')
                      ->leftJoin(DB::raw("(select item_id, max(progress_status)AS max_s from item_progresses where status <> 'X' group by item_id) AS IP_SQ"), 'IP_SQ.item_id', '=', 'I.id')
                      ->where('I.status', '<>', 'X')
                      ->when($item_id, function ($query) use ($item_id){
                        return $query->where('I.id', '=', $item_id);
                      })
                      ->when($request_id, function ($query) use ($request_id){
                        return $query->where('I.request_id', '=', $request_id);
                      })
                      ->when($item_name, function ($query) use ($item_name){
                        return $query->where('I.name', 'LIKE', '%'.$item_name.'%');
                      })
                      ->when($progress, function ($query) use ($progress){
                        return $query->where('IP_SQ.max_s', '=', $progress);
                      })
                      ->when($category_no, function ($query) use ($category_no){
                        return $query->where('I.category', '=', $category_no);
                      })
                      ->when($maker_no, function ($query) use ($maker_no){
                        return $query->where('I.maker', '=', $maker_no);
                      })
                      ->orderBy('I.created_at', 'DESC')
                      ->paginate(5);

      $i_prges    = config('item_progress');
      $out_conds  = config('outside_condition');
      $in_conds   = config('inside_condition');
      $categories = DB::table('item_categories')
                      ->select('id', 'name')
                      ->get();
      $makers     = DB::table('item_makers')
                      ->select('id', 'name')
                      ->get();

      $i_search_title   = config('item_search_title');
      $search_condition = compact(
        'item_id',
        'request_id',
        'item_name',
        'progress',
        'category_no',
        'maker_no'
      );
      //dd($category);
      //検索条件の有無をチェック 無い場合は「検索条件」の文字を非表示にするため
      $isEmpty = array_filter($search_condition);
      //dd($items_results);
      return view('item.index', [
        'items_results'     =>  $items_results,
        'out_conds'         =>  $out_conds,
        'in_conds'          =>  $in_conds,
        'i_prges'           =>  $i_prges,
        'categories'        =>  $categories,
        'makers'            =>  $makers,
        'search_condition'  =>  $search_condition,
        'i_search_title'    =>  $i_search_title,
        'isEmpty'           =>  $isEmpty,
        'item_id'           =>  $item_id,
        'request_id'        =>  $request_id,
        'item_name'         =>  $item_name,
        'progress'          =>  $progress,
        'category_no'       =>  $category_no,
        'maker_no'          =>  $maker_no
      ]);
    }

    /**
     * itemの詳細画面
     */
    public function edit($itemId){
      return self::viewEdit($itemId);
    }

    /**
     * Itemのupdate
     */
    public function update(Request $request, $itemId){
      //dd($request);
      ///////////////////////////////////////////////////////////////
      ////                  item
      ///////////////////////////////////////////////////////////////
      $item = Item::findOrFail($itemId);
      $item->start_price    = $request->start_price ? str_replace(',', '', $request->start_price): null;
      $item->expsell_price  = $request->expsell_price ? str_replace(',', '', $request->expsell_price): null;
      $item->sell_price     = $request->sell_price ? str_replace(',', '', $request->sell_price): null;
      $item->memo           = $request->summary_memo_sub;
      $item->updter         = $request->updter;
      $item->save();
      ///////////////////////////////////////////////////////////////
      ////               item_progress
      ///////////////////////////////////////////////////////////////
      $iProgress = new ItemProgress();
      $latestIP  = DB::table('item_progresses')
                      ->select('flow_no', 'progress_status')
                      ->where('item_id', '=', $itemId)
                      ->latest('created_at')
                      ->first();
      if(empty($latestIP) || $latestIP->progress_status !== intval($request->progress_status)){ //進捗があったら更新
        $flow_no = $latestIP ? $latestIP->flow_no : 0;
        $latest_flow_no = intval($flow_no)+1;
        $iProgress->item_id      = $itemId;
        $iProgress->flow_no         = $latest_flow_no;
        $iProgress->progress_status = $request->progress_status;
        $iProgress->progress_memo   = $request->progress_memo;
        $iProgress->status          = $request->status;
        $iProgress->rgster          = $request->rgster;
        $iProgress->updter          = $request->updter;
        $iProgress->save();
      }

      return self::viewEdit($item->id);
    }

    /**
     * ItemオブジェクトをDBより取得する処理
     * @param $itemId str
     * @return Item obj
     */
    public function viewEdit($itemId){
      $item = DB::table('items AS I')
                ->select(
                  'I.id AS i_id',
                  'I.request_id AS r_id',
                  'IC.name AS ic_name',
                  'IM.name AS im_name',
                  'I.outside_condition AS o_cond',
                  'I.inside_condition AS i_cond',
                  'I.name AS i_name',
                  'I.cooling_off_flg AS cooling_off_flg',
                  'I.estimate_price AS estimate_price',
                  'I.buy_price AS buy_price',
                  'I.start_price AS start_price',
                  'I.expsell_price AS expsell_price',
                  'I.sell_price AS sell_price',

                  'I.expsell_min_price AS expsell_min_price',
                  'I.expsell_max_price AS expsell_max_price',
                  'I.exp_min_profit AS exp_min_profit',
                  'I.exp_max_profit AS exp_max_profit',
                  'I.exp_min_profit_rate AS exp_min_profit_rate',
                  'I.exp_max_profit_rate AS exp_max_profit_rate',

                  'I.memo AS memo'
                  )
                ->leftJoin('item_categories AS IC', 'IC.id', '=', 'I.category')
                ->leftJoin('item_makers AS IM', 'IM.id', '=', 'I.maker')
                ->where('I.id', '=', $itemId)
                ->first();
      //買取金額と落札金額がともに存在する場合、粗利・粗利率計算
      if($item->buy_price && $item->sell_price){
        $profit = $item->sell_price - $item->buy_price;
        $profit_rate = ($profit/$item->sell_price)*100;
      }
      else{
        $profit = null;
        $profit_rate = null;
      }

      $iProgresses = DB::table('item_progresses')
                      ->select('item_progresses.created_at AS dt', 'item_progresses.progress_memo AS memo', 'users.name AS name', 'item_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'item_progresses.rgster')
                      ->where('item_id', '=', $itemId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $latestSts  = count($iProgresses) != 0 ? $iProgresses[0]->status : 1 ;

      $out_conds        = config('outside_condition');
      $in_conds         = config('inside_condition');
      $cooling_offs     = config('cooling_off');
      $item_progresses  = config('item_progress');

      return view('item.edit',[
        'item'            =>  $item,
        'out_conds'       =>  $out_conds,
        'in_conds'        =>  $in_conds,
        'cooling_offs'    =>  $cooling_offs,
        'i_prges'         =>  $item_progresses,
        'iProgresses'     =>  $iProgresses,
        'latestSts'       =>  $latestSts,
        'profit'          =>  $profit,
        'profit_rate'     =>  $profit_rate
      ]);
    }
}
