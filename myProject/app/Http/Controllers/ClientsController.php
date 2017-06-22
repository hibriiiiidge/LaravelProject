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
      $baseTypes = DB::table('base_types')
                      ->where('status', '<>', 'X')
                      ->get();//拠点一覧を取得
      $client     = new Client();
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
      $routes       = DB::table('routes')
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
        'item_makers'     =>  $item_makers
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
      //   'kana'        => 'required|string|max:255',
      //   'gender'      => 'required|integer',
      //   'job'         => 'required|integer',
      //   'birthday'    => 'required|string|max:255',
      //   'tel'         => 'required|string|max:255',
      //   'email'       => 'required|string|email|max:255',
      //   'postal_code' => 'required|string|max:255',
      //   'prefecture'  => 'required|integer',
      //   'address'     => 'required|string|max:255',
      //   'role'        => 'required|integer',
      //   'status'      => 'required',
      //   'updter'      => 'required|string',
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
        $latestCNo = substr($latestCStr, -7); //文字列の後ろから7桁を取得
      }
      else{
        $latestCNo = $zero."1";
      }
      //nameの整形
      $fullname = $client->chgFullName($request->name); //スペース詰め
      list($last_name, $first_name) = $client->split_name($request->name);
      $fullkana = $client->chgFullName($request->kana); //スペース詰め
      list($last_kana, $first_kana) = $client->split_name($request->kana);

      $client->id               = $latestCNo;
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
      $client->rgster           = $request->rgster;
      $client->updter           = $request->updter;
      $client->status           = $request->status;
      $client->save();

      ///////////////////////////////////////////////////////////////
      ////                  request_detail
      ///////////////////////////////////////////////////////////////
      $date = date("Ymd");
      //依頼ID "日付+顧客ID"の13桁の逆文字列 ex 日付:20170609 顧客ID:0000012の場合
      //2100000906071
      $request_id = strrev(mb_substr($date.$client->id, -13));
      //概要メモの判定
      $summary_memo = $request->memo_type == 'main' ? $request->summary_memo_main :  $request->summary_memo_sub;
      $rDetail = new RequestDetail();
      $rDetail->request_id      = $request_id;
      $rDetail->client_id       = $latestCNo;
      $rDetail->urgency         = $request->urgency;
      $rDetail->reason          = $request->reason;
      $rDetail->buy_way         = $request->buy_way;
      $rDetail->contact_way     = $request->contact_way;
      $rDetail->route           = $request->route;
      $rDetail->competitive_flg = $request->competitive_flg;
      $rDetail->summary_memo    = $summary_memo;
      $rDetail->rgster          = $request->rgster;
      $rDetail->updter          = $request->updter;
      $rDetail->status          = $request->status;
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
      for ($i=0; $i < count($request->category); $i++) {
        $item_n = $i+1;
        $item = new Item();
        $item->id                   = ($rDetail->request_id)."_".$item_n;
        $item->no_underscore_id     = ($rDetail->request_id).$item_n;
        $item->request_id           = $rDetail->request_id;
        $item->count                = $item_n;
        $item->category             = $request->category[$i];
        $item->maker                = $request->maker[$i];
        $item->name                 = $request->item_name[$i];
        $item->outside_condition    = $request->outside_condition ? current(array_slice($request->outside_condition, $i, 1, true)) : null;
        $item->inside_condition     = $request->inside_condition ? current(array_slice($request->inside_condition, $i, 1, true)) : null;
        $item->cooling_off_flg      = $request->cooling_off_flg ? current(array_slice($request->cooling_off_flg, $i, 1, true)) : null;
        $item->memo                 = $request->item_memo ? current(array_slice($request->item_memo, $i, 1, true)) : null;
        $item->estimate_price       = $request->estimate_price[$i] ? str_replace(',', '', $request->estimate_price[$i]) : null;
        $item->expsell_min_price    = $request->expsell_min_price[$i] ? str_replace(',', '', $request->expsell_min_price[$i]): null;
        $item->expsell_max_price    = $request->expsell_max_price[$i] ? str_replace(',', '', $request->expsell_max_price[$i]): null;
        $item->exp_min_profit       = $request->exp_min_profit[$i] ? str_replace(',', '', $request->exp_min_profit[$i]): null;
        $item->exp_max_profit       = $request->exp_max_profit[$i] ? str_replace(',', '', $request->exp_max_profit[$i]): null;
        $item->exp_min_profit_rate  = $request->exp_min_profit_rate[$i];
        $item->exp_max_profit_rate  = $request->exp_max_profit_rate[$i];
        $item->buy_price            = $request->buy_price[$i] ? str_replace(',', '', $request->buy_price[$i]): null;
        $item->sell_price           = $request->sell_price[$i] ? str_replace(',', '', $request->sell_price[$i]): null;
        $item->profit               = $request->profit[$i] ? str_replace(',', '', $request->profit[$i]): null;
        $item->profit_rate          = $request->profit_rate[$i];
        //$item->number               = $request->number[$i];
        $item->status             = $request->item_status;
        $item->rgster             = $request->rgster;
        $item->updter             = $request->updter;
        $item->save();
      }
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }

    /**
     * 顧客・依頼・商品情報の編集画面への遷移
     *
     */
    public function edit($clientId, $requestDetailId){
      //@TODO destroyと同じ処理をまとめる
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->first();
      $baseTypes = DB::table('base_types')
                      ->where('status', '<>', 'X')
                      ->get();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $latestSts  = $rProgresses[0]->status;
      $items      = Item::where('request_id', $requestDetailId)->where('status', '<>', 'X')->orderBy('created_at', 'ASC')->get();
      $itemsCnt   = count($items);
      $prefs      = config('pref');
      $prges      = config('progress'); //進捗状況取得
      $prg_nums    = config('progress_num');
      $urgencys   = config('urgency');
      $reasons    = config('reason');
      $buy_ways   = config('buy_way');
      $contact_ways = config('contact_way');
      $jobs       = config('job');
      $routes     = DB::table('routes')
                      ->where('status', '<>', 'X')
                      ->get();                        //サイト一覧を取得
      $item_categories  = DB::table('item_categories')
                            ->where('status', '<>', 'X')
                            ->get();                    //商品カテゴリー一覧を取得
      $item_makers      = DB::table('item_makers')
                            ->where('status', '<>', 'X')
                            ->get();                    //メーカー一覧を取得
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
        'item_makers'     =>  $item_makers
      ]);
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
      $client->updter           = $request->updter;
      $client->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_detail
      ///////////////////////////////////////////////////////////////
      //概要メモの判定
      $summary_memo = $request->memo_type == 'main' ? $request->summary_memo_main :  $request->summary_memo_sub;
      $rDetail = RequestDetail::where('request_id', '=', $requestDetailId)->first();
      $rDetail->urgency         = $request->urgency;
      $rDetail->reason          = $request->reason;
      $rDetail->buy_way         = $request->buy_way;
      $rDetail->contact_way     = $request->contact_way;
      $rDetail->route           = $request->route;
      $rDetail->competitive_flg = $request->competitive_flg;
      $rDetail->summary_memo    = $summary_memo;
      $rDetail->updter          = $request->updter;
      $rDetail->save();
      ///////////////////////////////////////////////////////////////
      ////                  request_progress
      ///////////////////////////////////////////////////////////////
      $rProgress = new RequestProgress();
      $latestRP  = DB::table('request_progresses')
                        ->where('request_id', '=', $requestDetailId)
                        ->select('flow_no', 'progress_status')->latest('created_at')->first();
      if($latestRP->progress_status !== intval($request->progress_status)){ //進捗があったら更新
        $flowNo = intval($latestRP->flow_no)+1;
        $rProgress->request_id      = $requestDetailId;
        $rProgress->flow_no         = $flowNo;
        $rProgress->progress_status = $request->progress_status;
        $rProgress->progress_memo   = $request->progress_memo;
        $rProgress->status          = $request->status; //@TODO nullableに変更
        $rProgress->rgster          = $request->rgster;
        $rProgress->updter          = $request->updter;
        $rProgress->save();
      }
      ///////////////////////////////////////////////////////////////
      ////                  item
      ///////////////////////////////////////////////////////////////
      $items = $rDetail->items;     //request_detailsに紐づくitemの取得 status<>"X"の条件
      //dd($items);
      $dbItemsCnt = count($items);  //request_detailsに紐づくitemの数
      for ($i=0; $i < $dbItemsCnt; $i++) {
        $items[$i]->category             = $request->category[$i];
        $items[$i]->maker                = $request->maker[$i];
        $items[$i]->name                 = $request->item_name[$i];
        $items[$i]->outside_condition    = $request->outside_condition[$items[$i]->no_underscore_id];
        $items[$i]->inside_condition     = $request->inside_condition[$items[$i]->no_underscore_id];
        $items[$i]->cooling_off_flg      = $request->cooling_off_flg[$items[$i]->no_underscore_id];
        $items[$i]->memo                 = $request->item_memo[$i];
        $items[$i]->estimate_price       = $request->estimate_price[$i] ? str_replace(',', '', $request->estimate_price[$i]) : null;
        $items[$i]->expsell_min_price    = $request->expsell_min_price[$i] ? str_replace(',', '', $request->expsell_min_price[$i]): null;
        $items[$i]->expsell_max_price    = $request->expsell_max_price[$i] ? str_replace(',', '', $request->expsell_max_price[$i]): null;
        $items[$i]->exp_min_profit       = $request->exp_min_profit[$i] ? str_replace(',', '', $request->exp_min_profit[$i]): null;
        $items[$i]->exp_max_profit       = $request->exp_max_profit[$i] ? str_replace(',', '', $request->exp_max_profit[$i]): null;
        $items[$i]->exp_min_profit_rate  = $request->exp_min_profit_rate[$i];
        $items[$i]->exp_max_profit_rate  = $request->exp_max_profit_rate[$i];
        $items[$i]->buy_price            = $request->buy_price[$i] ? str_replace(',', '', $request->buy_price[$i]): null;
        $items[$i]->sell_price           = $request->sell_price[$i] ? str_replace(',', '', $request->sell_price[$i]): null;
        $items[$i]->profit               = $request->profit[$i] ? str_replace(',', '', $request->profit[$i]): null;
        $items[$i]->profit_rate          = $request->profit_rate[$i];
        $items[$i]->updter             = $request->updter;
        if($items[$i]->no_underscore_id == $request->return_items[$i]){
          $items[$i]->status = "R";
          $items[$i]->return_reason = $request->return_reasons[$i];
        }
        $items[$i]->save();
      }

      $newItemsCnt = count($request->category) - $dbItemsCnt; //edit画面で新規に追加されたitem数 categoryは必須項目

      if($newItemsCnt>0){
        for ($i=0; $i < $newItemsCnt; $i++) {
          $latestId = DB::table('items')->select('count')->where('request_id', $requestDetailId)->orderBy('count', 'DESC')->take(1)->first();
          $item_n = intval($latestId->count)+1; //カウント+1 status<>'X'も含む通し番号
          $n = $dbItemsCnt+$i;
          $item = new Item();
          $item->id                 = ($rDetail->request_id)."_".$item_n;
          $item->no_underscore_id   = ($rDetail->request_id).$item_n;
          $item->count              = $item_n;
          $item->request_id         = $rDetail->request_id;
          $item->category           = $request->category[$n];
          $item->maker              = $request->maker[$n];
          $item->name               = $request->item_name[$n];
          $item->outside_condition  = $request->outside_condition ? current(array_slice($request->outside_condition, $n, 1, true)) : null;
          $item->inside_condition   = $request->inside_condition ? current(array_slice($request->inside_condition, $n, 1, true)) : null;
          $item->cooling_off_flg    = $request->cooling_off_flg ? current(array_slice($request->cooling_off_flg, $n, 1, true)) : null;
          $item->memo               = $request->item_memo ? current(array_slice($request->item_memo, $n, 1, true)) : null;

          $item->estimate_price       = $request->estimate_price[$n] ? str_replace(',', '', $request->estimate_price[$n]) : null;
          $item->expsell_min_price    = $request->expsell_min_price[$n] ? str_replace(',', '', $request->expsell_min_price[$n]): null;
          $item->expsell_max_price    = $request->expsell_max_price[$n] ? str_replace(',', '', $request->expsell_max_price[$n]): null;
          $item->exp_min_profit       = $request->exp_min_profit[$n] ? str_replace(',', '', $request->exp_min_profit[$n]): null;
          $item->exp_max_profit       = $request->exp_max_profit[$n] ? str_replace(',', '', $request->exp_max_profit[$n]): null;
          $item->exp_min_profit_rate  = $request->exp_min_profit_rate[$n];
          $item->exp_max_profit_rate  = $request->exp_max_profit_rate[$n];
          $item->buy_price            = $request->buy_price[$n] ? str_replace(',', '', $request->buy_price[$n]): null;
          $item->sell_price           = $request->sell_price[$n] ? str_replace(',', '', $request->sell_price[$n]): null;
          $item->profit               = $request->profit[$n] ? str_replace(',', '', $request->profit[$n]): null;
          $item->profit_rate          = $request->profit_rate[$n];

          $item->status             = $request->status;
          $item->rgster             = $request->rgster;
          $item->updter             = $request->updter;
          $item->save();
        }
      }
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }


    /**
     * edit画面からitemを削除する際の処理
     */
    public function destroy(Request $request, $clientId, $requestDetailId){
      //@TODO editと同一処理をまとめる
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->first();
      $baseTypes = DB::table('base_types')
                      ->where('status', '<>', 'X')
                      ->get();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $latestSts = $rProgresses[0]->status;

      //論理削除
      $item = Item::where('no_underscore_id', $request->deleteItemId)->first();
      $item->status = "X";
      $item->save();
      $items = Item::where('request_id', $requestDetailId)->where('status', '<>', 'X')->orderBy('created_at', 'ASC')->get();
      $itemsCnt = count($items);
      return view('client.edit', ['client'=>$client, 'requestDetail'=>$requestDetail, 'baseTypes'=>$baseTypes, 'rProgresses'=>$rProgresses, 'latestSts'=>$latestSts, 'items'=>$items, 'itemsCnt'=>$itemsCnt]);
    }
}
