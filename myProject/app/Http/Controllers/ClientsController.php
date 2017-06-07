<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\BaseType;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function create(){
      //拠点一覧を取得
      $baseTypes = BaseType::all();
      return view('client.register', ['baseTypes' => $baseTypes]);
    }

    public function store(Request $request){
      $this->validate($request, [
        'attribute'   => 'required|integer',
        'base'        => 'required|integer',
        'name'        => 'required|string|max:255',
        'kana'        => 'required|string|max:255',
        'gender'      => 'required|integer',
        'job'         => 'required|integer',
        'birthday'    => 'required|string|max:255',
        'tel'         => 'required|string|max:255',
        'email'       => 'required|string|email|max:255',
        'postal_code' => 'required|string|max:255',
        'prefecture'  => 'required|integer',
        'address'     => 'required|string|max:255',
        'role'        => 'required|integer',
        'status'      => 'required',
        'updter'      => 'required|string',
      ]);

      //"0"埋め処理、7桁
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
        $latestCNo = substr($latestCStr, -7);
      }
      else{
        $latestCNo = $zero."1";
      }

      $client = new Client();
      $client->id           = $latestCNo;
      $client->attribute    = $request->attribute;
      $client->base         = $request->base;
      $client->name         = $request->name;
      $client->kana         = $request->kana;
      $client->gender       = $request->gender;
      $client->job          = $request->job;
      $client->birthday     = $request->birthday;
      $client->tel          = $request->tel;
      $client->mail         = $request->mail;
      $client->postal_code  = $request->postal_code;
      $client->prefecture   = $request->prefecture;
      $client->address      = $request->address;
      $client->memo         = $request->memo;
      $client->rgster       = $request->rgster;
      $client->updter       = $request->updter;
      $client->status       = $request->status;
      $client->save();
      //dd($client);
      return redirect('/home');
    }
}
