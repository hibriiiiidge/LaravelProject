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
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    /**
     *  request_detail一覧表示 登録日時の降順
     */
    public function index(){
      $prges      = config('progress');
      $out_conds  = config('outside_condition');
      $in_conds   = config('inside_condition');

      $items_results = DB::table('items AS I')
                      ->select(
                        'I.id AS i_id',
                        'I.request_id AS r_id',
                        'RD.client_id AS c_id',
                        'RP.progress_status AS p_status',
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
                      ->where('I.status', '<>', 'X')
                      ->orderBy('I.created_at', 'DESC')
                      ->paginate(5);
      //dd($items_results);
      return view('item.index', [
        'items_results' =>  $items_results,
        'out_conds'     =>  $out_conds,
        'in_conds'      =>  $in_conds,
        'prges'         =>  $prges
      ]);
    }

    /**
     * itemの詳細画面
     */
    public function edit($itemId){
      //dd($clientId);
      return self::viewEdit($itemId);
    }

    /**
     * Itemのupdate
     */
    public function update(Request $request, $itemId){
      ///////////////////////////////////////////////////////////////
      ////                  item
      ///////////////////////////////////////////////////////////////
      $item = Item::findOrFail($itemId);
      $item->start_price    = $request->start_price ? str_replace(',', '', $request->start_price): null;
      $item->expsell_price  = $item->expsell_price ? str_replace(',', '', $request->expsell_price): null;
      $item->sell_price     = $item->sell_price ? str_replace(',', '', $request->sell_price): null;
      $item->memo           = $request->summary_memo_sub;
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
        'latestSts'       =>  $latestSts
      ]);
    }
}
