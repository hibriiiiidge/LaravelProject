<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\BaseType;
use App\RequestDetail;
use App\RequestProgress;
use App\Item;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    /**
     * 顧客・依頼・商品情報の新規登録画面への繊維
     *
     */
    public function create(){
      $client     = new Client();
      return self::viewRgst($client);
    }

    /**
     * リピート登録画面への繊維
     * @param client_id str
     */
    public function repeat($clientId){
      $client = Client::where('id', '=', $clientId)->first();
      return self::viewRgst($client);
    }

    /**
     * createとrepeatの重複処理
     * @param client obj
     */
    public function viewRgst(Client $client){
      $rDetail    = new RequestDetail();
      $item       = new Item();
      $itemsCnt   = 1; //削除ボタンの表示・非表示と連動 商品入力フォームの数が ">0" の時に削除ボタンが表示
      $latestSts  = null;
      $prefs      = config('pref'); //都道府県取得
      $prges      = config('progress'); //進捗状況取得
      $prg_nums   = config('progress_num');
      $urgencys   = config('urgency');
      $reasons    = config('reason');
      $buy_ways   = config('buy_way');
      $contact_ways = config('contact_way');
      $jobs       = config('job');
      $out_conds  = config('outside_condition');
      $in_conds   = config('inside_condition');

      $baseTypes  = DB::table('base_types')
                      ->where('status', '<>', 'X')
                      ->get();//拠点一覧を取得
      $routes     = DB::table('routes')
                      ->where('status', '<>', 'X')
                      ->get();                    //サイト一覧を取得
      $item_categories  = DB::table('item_categories')
                            ->where('status', '<>', 'X')
                            ->get();                    //商品カテゴリー一覧を取得
      $item_makers      = DB::table('item_makers')
                            ->where('status', '<>', 'X')
                            ->get();                    //商品カテゴリー一覧を取得
      return view('client.register', [
        'baseTypes'     =>  $baseTypes,
        'client'        =>  $client,
        'requestDetail' =>  $rDetail,
        'item'          =>  $item,
        'itemsCnt'      =>  $itemsCnt,
        'latestSts'     =>  $latestSts,
        'prefs'         =>  $prefs,
        'routes'        =>  $routes,
        'prges'         =>  $prges,
        'prg_nums'      =>  $prg_nums,
        'urgencys'      =>  $urgencys,
        'reasons'       =>  $reasons,
        'buy_ways'      =>  $buy_ways,
        'contact_ways'  =>  $contact_ways,
        'jobs'          =>  $jobs,
        'item_categories' =>  $item_categories,
        'item_makers'     =>  $item_makers,
        'out_conds'    => $out_conds,
        'in_conds'     => $in_conds
      ]);
    }

    /**
     * 顧客・依頼・商品情報の新規登録処理
     *
     */
    public function store(Request $request){
      //dd($request);
      //@TODO バリデーション
      // $this->validate($request, [
      //   'attribute'   => 'required|integer',
      //   'base'        => 'required|integer',
      //   'name'        => 'required|string|max:255',
      //   'kana'        => 'required|string|max:255'
      // ]);
      ///////////////////////////////////////////////////////////////
      ////                        Client
      ///////////////////////////////////////////////////////////////
      $client = new Client();
      //IDの生成
      $zero = $client->zeroNum($client::ZEROCNT);
      //Clientが既に存在していたら、最新のID番号を取得し、+1して、新規のClientの番号とする
      $latestId = DB::table('clients')->select('id')->latest()->first();
      if($latestId){
        $latestCNum = 1+intval($latestId->id);
        $latestCStr  = $zero.strval($latestCNum);
        $latestCNo = substr($latestCStr, -4); //文字列の後ろから4桁を取得
      }
      else{
        $latestCNo = $zero."1";
      }
      $client->id               = $latestCNo;
      $client = self::attachClient($client, $request);
      $client->rgster           = $request->rgster;
      $client->updter           = $request->updter;
      $client->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_detail
      ///////////////////////////////////////////////////////////////
      $date = date("Ymd");
      //依頼ID
      $request_id = mb_substr($date.$client->id, -10);
      $rDetail = new RequestDetail();
      $rDetail->request_id      = $request_id;
      $rDetail->client_id       = $latestCNo;
      $rDetail  = self::attachRequestDetail($rDetail, $request);
      $rDetail->status          = $request->status;
      $rDetail->rgster          = $request->rgster;
      $rDetail->updter          = $request->updter;
      $rDetail->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_progress
      ///////////////////////////////////////////////////////////////
      $rProgress = new RequestProgress();
      $rProgress->request_id      = $rDetail->request_id;
      $rProgress->flow_no         = 1; //新規登録なので連番は必ず"1"からスタート
      $rProgress->progress_status = $request->progress_status;
      $rProgress->progress_memo   = $request->progress_memo;
      $rProgress->status          = $request->status;
      $rProgress->rgster          = $request->rgster;
      $rProgress->updter          = $request->updter;
      $rProgress->save();

      ///////////////////////////////////////////////////////////////
      ////                  item
      ///////////////////////////////////////////////////////////////
      $allcount = array();
      for ($i=0; $i < count($request->category); $i++) {
        for ($j=0; $j < $request->item_num[$i]; $j++) {
          $allcount[] = 1;   //案件に紐付くitem総数をカウントするため
          $item_group_n = $i+1;
          $item_n = $j+1;
          $item = new Item();
          $item->id                   = ($rDetail->request_id)."-".$item_group_n."-".$item_n;
          $item->item_group           = ($rDetail->request_id)."-".$item_group_n;
          $item->no_underscore_id     = ($rDetail->request_id).$item_group_n.$item_n;
          $item->item_no              = $item_n;
          $item->item_group_no        = $item_group_n;
          $item->request_id           = $rDetail->request_id;
          $item->count                = count($allcount);
          $item = self::attcheItem($item, $i, $request);
          $item->status               = $request->item_status;
          $item->rgster               = $request->rgster;
          $item->updter               = $request->updter;
          $item->save();
        }
      }
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }

    /**
     * 顧客・依頼・商品情報の編集画面への遷移
     *
     */
    public function edit($clientId, $requestDetailId){
      return self::viewEdit($clientId, $requestDetailId);
    }

    /**
     * 顧客・依頼・商品情報の更新処理
     *
     */
    public function update(Request $request, $clientId, $requestDetailId){
      //dd($request);
      ///////////////////////////////////////////////////////////////
      ////                        Client
      ///////////////////////////////////////////////////////////////
      $client = Client::findOrFail($clientId);
      $client = self::attachClient($client, $request);
      $client->updter           = $request->updter;
      $client->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_detail
      ///////////////////////////////////////////////////////////////
      $rDetail = RequestDetail::where('request_id', '=', $requestDetailId)->first();
      $rDetail  = self::attachRequestDetail($rDetail, $request);
      $rDetail->updter = $request->updter;
      $rDetail->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_progress
      ///////////////////////////////////////////////////////////////
      $rProgress = new RequestProgress();
      $latestRP  = DB::table('request_progresses')
                        ->select('flow_no', 'progress_status')
                        ->where('request_id', '=', $requestDetailId)
                        ->latest('created_at')
                        ->first();
      if($latestRP->progress_status !== intval($request->progress_status)){ //進捗があったら更新
        $flowNo = intval($latestRP->flow_no)+1;
        $rProgress->request_id      = $requestDetailId;
        $rProgress->flow_no         = $flowNo;
        $rProgress->progress_status = $request->progress_status;
        $rProgress->progress_memo   = $request->progress_memo;
        $rProgress->status          = $request->status;
        $rProgress->rgster          = $request->rgster;
        $rProgress->updter          = $request->updter;
        $rProgress->save();
      }
      ///////////////////////////////////////////////////////////////
      ////                  item
      ///////////////////////////////////////////////////////////////
      //DBに保存されているitem_groupと数を取得
      $dbItmeGroups = DB::table('items')
                        ->select(DB::raw('item_group, count(*) AS sameItemCnt'))
                        ->where('request_id', '=', $request->request_id)
                        ->where('status', '<>', 'X')
                        ->groupBy('item_group')
                        ->get();
      //item_groupを配列に変形
      $dbAry = array();
      for ($i=0; $i < count($dbItmeGroups); $i++) {
        $dbAry[] = $dbItmeGroups[$i]->item_group;
      }
      //requestのitem_groupを配列に変形
      $rqAry = array();
      for ($i=0; $i < count($request->item_group); $i++) {
        $rqAry[] = $request->item_group[$i];
      }
      //DBとrequest->item_groupに共通で存在するitem_groupの配列を取得
      $comnAry = array();
      $comnAry = array_intersect($dbAry, $rqAry);
      //$comnAryに存在するitem_groupの中の商品数の増減を確認する
      for ($i=0; $i <count($comnAry) ; $i++) {
        $diffCnt =  $request->item_num[$i] - $dbItmeGroups[$i]->sameItemCnt;
        //増の場合
        if($diffCnt>0){
          //増加分だけItemをnewする
          for ($j=0; $j < $diffCnt; $j++) {
            //値の整形
            $latestItem = DB::table('items')
                            ->select('id')
                            ->where('item_group', '=', $comnAry[$i])
                            ->orderBy('count', 'DESC')
                            ->take(1)
                            ->first();
            $sprtIds    = explode('-', $latestItem->id);
            $newItemNo  = 1+intval($sprtIds[2]);
            $itemCnt    = DB::table('items')
                            ->select(DB::raw('count(*) AS cnt'))
                            ->where('request_id', '=', $request->request_id)
                            ->first();
            $newCount = $itemCnt->cnt + 1;
            $sprtItemGroup = explode('-',$comnAry[$i]);
            $noscore_item_group = str_replace('-','', $comnAry[$i]);

            $item = new Item();
            $item->id                   = $comnAry[$i]."-".$newItemNo;
            $item->item_group           = $comnAry[$i];
            $item->no_underscore_id     = $noscore_item_group.$newItemNo;
            $item->item_no              = $newItemNo;
            $item->item_group_no        = $sprtItemGroup[1];
            $item->request_id           = $request->request_id;
            $item->count                = $newCount;
            $item = self::attcheItem($item, $i, $request);
            $item->status               = $request->item_status;
            $item->rgster               = $request->rgster;
            $item->updter               = $request->updter;
            $item->save();
          }
        }
        //減の場合
        elseif($diffCnt<0){
          //論理削除
          //item_groupのcoutn値が大きいものから削除
          $items = DB::table('items')
                      ->select('id')
                      ->where('item_group', '=', $comnAry[$i])
                      ->where('status', '<>', 'X')
                      ->orderBy('count', 'DESC')
                      ->get();
          $absDiff = abs($diffCnt);
          for ($k=0; $k < $absDiff ; $k++) {
            $item = Item::where('id', '=', $items[$k]->id)
                        ->first();
            $item->status = "X";
            $item->save();
          }
        }
        //同じ場合
        elseif($diffCnt == 0){
          //更新
          $items = DB::table('items')
                      ->select('id')
                      ->where('item_group', '=', $comnAry[$i])
                      ->where('status', '<>', 'X')
                      ->get();
          for ($n=0; $n < count($items) ; $n++) {
            $item = Item::where('id', '=', $items[$n]->id)
                          ->first();
            $item = self::attcheItem($item, $i, $request);
            $item->updter = $request->updter;
            $item->save();
          }
        }
      }

      //新規で追加された商品の数だけ登録
      //$comnAryの数+1番目から新規の商品が始まる
      for ($i=count($comnAry); $i < count($request->item_group) ; $i++) {
        //値の整形
        $latestIemGrpNo = DB::table('items')
                          ->select('item_group_no')
                          ->where('request_id', '=', $request->request_id)
                          ->groupBy('item_group_no')
                          ->orderBy('item_group_no', 'DESC')
                          ->take(1)
                          ->first();
        $item_group_n = ($latestIemGrpNo->item_group_no)+1;
          for ($j=0; $j < $request->item_num[$i]; $j++) {
          $item_n = $j+1;
          $itemCnt     = DB::table('items')
                          ->select(DB::raw('count(*) AS cnt'))
                          ->where('request_id', '=', $request->request_id)
                          ->first();
          $newCount = $itemCnt->cnt + 1;
          //登録
          $item = new Item();
          $item->id                   = ($rDetail->request_id)."-".$item_group_n."-".$item_n;
          $item->item_group           = ($rDetail->request_id)."-".$item_group_n;
          $item->no_underscore_id     = ($rDetail->request_id).$item_group_n.$item_n;
          $item->request_id           = $rDetail->request_id;
          $item->item_no              = $item_n;
          $item->item_group_no        = $item_group_n;
          $item->count                = $newCount;
          $item = self::attcheItem($item, $i, $request);
          $item->status               = $request->item_status;
          $item->rgster               = $request->rgster;
          $item->updter               = $request->updter;
          $item->save();
        }
      }
      //返品処理
      //返品item_group
      $returnAry = array();
      for ($i=0; $i < count($request->return_items); $i++) {
        if($request->return_items[$i]){
            $returnAry[] = $request->return_items[$i];
        }
      }
      //item_groupに紐づく返品理由
      $returnReasonAry = array();
      for ($i=0; $i < count($request->return_reasons); $i++) {
        if($request->return_items[$i]){
            $returnReasonAry[] = $request->return_reasons[$i];
        }
      }

      for ($i=0; $i < count($returnAry); $i++) {
        $items = Item::where('item_group', '=', $returnAry[$i])
                      ->where('status', '<>', 'X')
                      ->get();
        for ($j=0; $j < count($items); $j++) {
          $items[$j]->status = "R";
          $items[$j]->return_reason = $returnReasonAry[$i];
          $items[$j]->save();
        }
      }
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }


    /**
     * edit画面からitemを削除する際の処理
     */
    public function destroy(Request $request, $clientId, $requestDetailId){
      //dd($request);
      //論理削除
      $items = Item::where('item_group', '=', $request->deleteItemGroup)
                    ->where('status', '<>', 'X')
                    ->get();
      for ($i=0; $i < count($items); $i++) {
        $items[$i]->status = "X";
        $items[$i]->save();
      }
      return self::viewEdit($clientId, $requestDetailId);
    }

    /**
     * Edit画面へ遷移する処置 (storeとdelete同一処理をまとめたもの)
     */
    public function viewEdit($clientId, $requestDetailId){
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->first();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $latestSts  = $rProgresses[0]->status;
      $items = DB::table('items AS I')
                  ->rightJoin(DB::raw("(select item_group, min(no_underscore_id) AS repre_id  from items where request_id = ".$requestDetailId." and status <> 'X' group by item_group) AS RP_I"), 'RP_I.repre_id', '=', 'I.no_underscore_id')
                  ->leftJoin(DB::raw("(select item_group, count(*) AS all_cnt from items where request_id = ".$requestDetailId." and status <> 'X'  group by item_group) AS CNT_I"), 'CNT_I.item_group', '=', 'RP_I.item_group')
                  ->where('I.status', '<>', 'X')
                  ->get();
      $itemsCnt = count($items);
      $prefs      = config('pref');
      $prges      = config('progress'); //進捗状況取得
      $prg_nums   = config('progress_num');
      $urgencys   = config('urgency');
      $reasons    = config('reason');
      $buy_ways   = config('buy_way');
      $contact_ways = config('contact_way');
      $jobs       = config('job');
      $out_conds  = config('outside_condition');
      $in_conds   = config('inside_condition');
      $baseTypes  = DB::table('base_types')
                      ->where('status', '<>', 'X')
                      ->get();
      $routes     = DB::table('routes')
                      ->where('status', '<>', 'X')
                      ->get();                        //サイト一覧を取得
      $item_categories  = DB::table('item_categories')
                            ->where('status', '<>', 'X')
                            ->get();                    //商品カテゴリー一覧を取得
      $item_makers      = DB::table('item_makers')
                            ->where('status', '<>', 'X')
                            ->get();                    //メーカー一覧を取得
                            //dd($latestSts);
      return view('client.edit', [
        'client'          =>  $client,
        'requestDetail'   =>  $requestDetail,
        'baseTypes'       =>  $baseTypes,
        'rProgresses'     =>  $rProgresses,
        'latestSts'       =>  $latestSts,
        'items'           =>  $items,
        'itemsCnt'        =>  $itemsCnt,
        'prefs'           =>  $prefs,
        'routes'          =>  $routes,
        'prges'           =>  $prges,
        'prg_nums'        =>  $prg_nums,
        'urgencys'        =>  $urgencys,
        'reasons'         =>  $reasons,
        'buy_ways'        =>  $buy_ways,
        'contact_ways'    =>  $contact_ways,
        'jobs'            =>  $jobs,
        'item_categories' =>  $item_categories,
        'item_makers'     =>  $item_makers,
        'out_conds'       => $out_conds,
        'in_conds'        => $in_conds
      ]);
    }

    /**
     * Clientの各要素にrequest値を代入する処理
     * @param $client obj
     * @param $request obj
     * @return $client obj
     */
    public function attachClient(Client $client, $request){
      //nameの整形
      $fullname = $client->chgFullName($request->name); //スペース詰め
      list($last_name, $first_name) = $client->split_name($request->name);
      $fullkana = $client->chgFullName($request->kana); //スペース詰め
      list($last_kana, $first_kana) = $client->split_name($request->kana);
      $client->attribute        = $request->attribute;
      $client->base             = $request->base;
      $client->fullname         = $fullname;
      $client->fullkana         = $fullkana;
      $client->name             = $last_name;
      $client->kana             = $last_kana;
      $client->first_name       = $first_name;
      $client->first_name_kana  = $first_kana;
      $client->gender           = $request->gender;
      $client->job              = $request->job;
      $client->birthday         = $request->birthday;
      $client->tel              = $request->tel;
      $client->fax              = $request->fax;
      $client->mail             = $request->mail;
      $client->postal_code      = $request->postal_code;
      $client->prefecture       = $request->prefecture;
      $client->address          = $request->address;
      $client->memo             = $request->memo;
      $client->status           = $request->status;
      return $client;
    }

    /**
     * Request_detailの各要素にrequest値を代入する処理
     * @param $rDetail obj
     * @param $request obj
     * @return $rDetail obj
     */
    public function attachRequestDetail(RequestDetail $rDetail, $request){
      //概要メモの判定
      $summary_memo = $request->memo_type == 'main' ? $request->summary_memo_main :  $request->summary_memo_sub;
      $rDetail->urgency         = $request->urgency;
      $rDetail->reason          = $request->reason;
      $rDetail->buy_way         = $request->buy_way;
      $rDetail->contact_way     = $request->contact_way;
      $rDetail->route           = $request->route;
      $rDetail->competitive_flg = $request->competitive_flg;
      $rDetail->summary_memo    = $summary_memo;
      $rDetail->bank_name       = $request->bank_name;
      $rDetail->bank_code       = $request->bank_code;
      $rDetail->branch_name     = $request->branch_name;
      $rDetail->branch_code     = $request->branch_code;
      $rDetail->account_kind    = $request->account_kind;
      $rDetail->account_number  = $request->account_number;
      $rDetail->account_name    = $request->account_name;
      return $rDetail;
    }

    /**
     * Request_progressの各要素にrequest値を代入する処理
     * @TODO
     */
    public function attachRequestProgress(RequestProgress $rProgress, $request){
    }

    /**
     * Itemの各要素にrequest値を代入する処理
     * @param $item obj
     * @param $i integer
     * @param $request obj
     * @return $rDetail obj
     */
    public function attcheItem(Item $item, $i, $request){
      $item->category             = $request->category[$i];
      $item->maker                = $request->maker[$i];
      $item->name                 = $request->item_name[$i];
      $item->outside_condition    = $request->outside_condition ? current(array_slice($request->outside_condition, $i, 1, true)) : null;
      $item->inside_condition     = $request->inside_condition ? current(array_slice($request->inside_condition, $i, 1, true)) : null;
      $item->cooling_off_flg      = $request->cooling_off_flg ? current(array_slice($request->cooling_off_flg, $i, 1, true)) : null;
      $item->memo                 = $request->item_memo ? current(array_slice($request->item_memo, $i, 1, true)) : null;
      $item->estimate_price           = $request->estimate_price[$i] ? str_replace(',', '', $request->estimate_price[$i]) : null;
      $item->total_estimate_price     = $request->total_est_price[$i] ? str_replace(',', '', $request->total_est_price[$i]) : null;
      $item->expsell_min_price        = $request->expsell_min_price[$i] ? str_replace(',', '', $request->expsell_min_price[$i]): null;
      $item->total_expsell_min_price  = $request->total_expsell_min_price[$i] ? str_replace(',', '', $request->total_expsell_min_price[$i]) : null;
      $item->expsell_max_price        = $request->expsell_max_price[$i] ? str_replace(',', '', $request->expsell_max_price[$i]): null;
      $item->total_expsell_max_price  = $request->total_expsell_max_price[$i] ? str_replace(',', '', $request->total_expsell_max_price[$i]) : null;
      $item->exp_min_profit           = $request->exp_min_profit[$i] ? str_replace(',', '', $request->exp_min_profit[$i]): null;
      $item->total_exp_min_profit     = $request->total_exp_min_profit[$i] ? str_replace(',', '', $request->total_exp_min_profit[$i]): null;
      $item->exp_max_profit           = $request->exp_max_profit[$i] ? str_replace(',', '', $request->exp_max_profit[$i]): null;
      $item->total_exp_max_profit     = $request->total_exp_max_profit[$i] ? str_replace(',', '', $request->total_exp_max_profit[$i]): null;
      $item->exp_min_profit_rate      = $request->exp_min_profit_rate[$i];
      $item->exp_max_profit_rate      = $request->exp_max_profit_rate[$i];
      $item->buy_price                = $request->buy_price[$i] ? str_replace(',', '', $request->buy_price[$i]): null;
      $item->total_buy_price          = $request->total_buy_price[$i] ? str_replace(',', '', $request->total_buy_price[$i]): null;
    //$item->sell_price           = $request->sell_price[$i] ? str_replace(',', '', $request->sell_price[$i]): null;
    //$item->profit               = $request->profit[$i] ? str_replace(',', '', $request->profit[$i]): null;
    // $item->profit_rate          = $request->profit_rate[$i];
      return $item;
    }
}
