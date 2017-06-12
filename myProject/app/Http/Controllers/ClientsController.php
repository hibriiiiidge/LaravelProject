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
      //拠点一覧を取得
      $baseTypes = BaseType::all();
      return view('client.register', ['baseTypes' => $baseTypes]);
    }

    public function store(Request $request){
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
      // @TODO Client Modelにまとめるべき処理
      ////顧客ID 7桁の0埋め ex. '0000001', '0002034'
      $zeroCnt = 6;
      /**
       * @param  int 桁埋めする"0"の個数
       * @return str "000000"
       */
      function zeroNum(int $n){
        $zeroAry = array();
        for ($i=0; $i < $n ; $i++) {
          array_push($zeroAry, '0');
        }
        $zeroStr = implode("", $zeroAry);
        return $zeroStr;
      }

      $zero = zeroNum($zeroCnt);
      //Clientが既に存在していたら
      //最新のID番号を取得し、+1して、新規のClientの番号とする
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
      $fullname = str_replace(array(' ', '　'), '', $request->name); //スペース詰め
      /**
       * 姓と名の分割処理
       * @param string name
       * @return array [last_name, first_name]
       */
      function split_name($name){
        $nameAry = [];
        $name = str_replace('　', ' ', $name);
        $name = trim($name);
        $name = preg_replace('/\s+/', ' ', $name);
        $nameAry = explode(' ', $name);
        return $nameAry;
      }
      list($last_name, $first_name) = split_name($request->name);
      list($last_kana, $first_kana) = split_name($request->kana);

      //Client
      $client = new Client();
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
      ////                  request_detail
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
      $item = new Item();
      $item->id = ($rDetail->request_id)."_1"; //新規登録なので連番は必ず"1"からスタート $item->id = 依頼ID+"_n"; (n>0)
      $item->request_id = $rDetail->request_id;
      $item->category   = $request->category;
      $item->status     = $request->item_status;
      $item->rgster     = $request->rgster;
      $item->updter     = $request->updter;
      $item->save();
      return redirect()->action('ClientsController@edit', ['clientId'=>$client->id, 'requestDetailId'=>$rDetail->request_id]);
    }

    public function edit($clientId, $requestDetailId){
      $client = Client::findOrFail($clientId);
      $requestDetail = RequestDetail::where('request_id', $requestDetailId)->get();
      $baseTypes = BaseType::all();
      $rProgresses = DB::table('request_progresses')
                      ->select('request_progresses.created_at AS dt', 'request_progresses.progress_memo AS memo', 'users.name AS name', 'request_progresses.progress_status AS status')
                      ->leftJoin('users', 'users.id', '=', 'request_progresses.rgster')
                      ->where('request_id', '=', $requestDetailId)
                      ->orderBy('dt', 'desc')
                      ->get();
      $items = Item::where('request_id', $requestDetailId)->latest('created_at')->get();
      // dd($items[0]->category);
      return view('client.edit', ['client'=>$client, 'requestDetail'=>$requestDetail[0], 'baseTypes'=>$baseTypes, 'rProgresses'=>$rProgresses, 'items'=>$items]);
    }
}
