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
    public function create(){
      $baseTypes  = BaseType::all(); //拠点一覧を取得
      $client     = new Client();
      $rDetail    = new RequestDetail();
      $item       = new Item();
      return view('client.register', ['baseTypes' => $baseTypes, 'client'=>$client, 'requestDetail'=>$rDetail, 'item'=>$item]);
    }

    /**
     * 顧客・依頼・商品情報の新規登録処理
     *
     */
    public function store(Request $request){
      //dd($request);
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
      list($last_kana, $first_kana) = $client->split_name($request->kana);

      $client->id               = $latestCNo;
      $client->attribute        = $request->attribute;
      $client->base             = $request->base;
      $client->fullname         = $fullname;
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
      //dd($client);
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
        $item->id                 = ($rDetail->request_id)."_".$item_n;
        $item->no_underscore_id   = ($rDetail->request_id).$item_n;
        $item->request_id         = $rDetail->request_id;
        $item->count              = $item_n;
        $item->category           = $request->category[$i];
        $item->name               = $request->item_name[$i];
        $item->outside_condition  = $request->outside_condition ? current(array_slice($request->outside_condition, $i, 1, true)) : null;
        $item->inside_condition   = $request->inside_condition ? current(array_slice($request->inside_condition, $i, 1, true)) : null;
        $item->cooling_off_flg    = $request->cooling_off_flg ? current(array_slice($request->cooling_off_flg, $i, 1, true)) : null;
        $item->memo               = $request->item_memo ? current(array_slice($request->item_memo, $i, 1, true)) : null;
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
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->first();
      $baseTypes = BaseType::all();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $items = Item::where('request_id', $requestDetailId)->where('status', '<>', 'X')->orderBy('created_at', 'ASC')->get();
      //dd($items);
      return view('client.edit', ['client'=>$client, 'requestDetail'=>$requestDetail, 'baseTypes'=>$baseTypes, 'rProgresses'=>$rProgresses, 'items'=>$items]);
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
      list($last_kana, $first_kana) = $client->split_name($request->kana);
      $client->attribute        = $request->attribute;
      $client->base             = $request->base;
      $client->fullname         = $fullname;
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
      $items = $rDetail->items; //request_detailsに紐づくitemの取得
      $dbItemsCnt = count($items);
      for ($i=0; $i < $dbItemsCnt; $i++) {
        $items[$i]->category           = $request->category[$i];
        $items[$i]->name               = $request->item_name[$i];
        $items[$i]->outside_condition  = $request->outside_condition[$items[$i]->no_underscore_id];
        $items[$i]->inside_condition   = $request->inside_condition[$items[$i]->no_underscore_id];
        $items[$i]->cooling_off_flg    = $request->cooling_off_flg[$items[$i]->no_underscore_id];
        $items[$i]->memo               = $request->item_memo[$i];
        $items[$i]->updter             = $request->updter;
        $items[$i]->save();
      }

      $newItemsCnt = count($request->category) - $dbItemsCnt;

      if($newItemsCnt>0){
        for ($i=0; $i < $newItemsCnt; $i++) {
          $latestId = DB::table('items')->select('id')->where('request_id', $requestDetailId)->orderBy('count', 'DESC')->take(1)->first();
          $latestNo = explode("_", $latestId->id);
          $item_n = intval($latestNo[1])+1;
          $n = $dbItemsCnt+$i;
          $item = new Item();
          $item->id                 = ($rDetail->request_id)."_".$item_n;
          $item->no_underscore_id   = ($rDetail->request_id).$item_n;
          $item->count              = $item_n;
          $item->request_id         = $rDetail->request_id;
          $item->category           = $request->category[$n];
          $item->name               = $request->item_name[$n];
          $item->outside_condition  = $request->outside_condition ? current(array_slice($request->outside_condition, $n, 1, true)) : null;
          $item->inside_condition   = $request->inside_condition ? current(array_slice($request->inside_condition, $n, 1, true)) : null;
          $item->cooling_off_flg    = $request->cooling_off_flg ? current(array_slice($request->cooling_off_flg, $n, 1, true)) : null;
          $item->memo               = $request->item_memo ? current(array_slice($request->item_memo, $n, 1, true)) : null;
          $item->status             = $request->status;
          $item->rgster             = $request->rgster;
          $item->updter             = $request->updter;
          $item->save();
        }
      }
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }


    /**
     *
     */
    public function destroy(Request $request, $clientId, $requestDetailId){
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->first();
      $baseTypes = BaseType::all();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $item = Item::where('no_underscore_id', $request->deleteItemId)->first();
      $item->status = "X";
      $item->save();
      $items = Item::where('request_id', $requestDetailId)->where('status', '<>', 'X')->orderBy('created_at', 'ASC')->get();
      //dd($items);
      return view('client.edit', ['client'=>$client, 'requestDetail'=>$requestDetail, 'baseTypes'=>$baseTypes, 'rProgresses'=>$rProgresses, 'items'=>$items]);
    }
}
