<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\BaseType;
use App\RequestDetail;
use App\RequestProgress;
use App\Item;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
  /**
   *  request_detail一覧表示 登録日時の降順
   */
  public function index(Request $request){
    $name = $request->name;
    $kana = $request->kana;
    //DB::enableQueryLog();
    $prg_nums = config('progress_num');
    $urgencys = config('urgency');
    $prges      = config('progress');
    $buy_ways   = config('buy_way');
    $prefs      = config('pref');
    $request_results = DB::table('request_details AS RD')
                          ->select(
                            'RD.request_id    AS request_id',
                            'RD.urgency       AS urgency',
                            'BT.short_name    AS base_name',
                            'RP_SQ.max_s      AS latest_status',
                            'RD.buy_way       AS buy_way',
                            'C.name           AS c_name',
                            'C.first_name     AS c_fname',
                            'I_SQ.name        AS i_name',
                            'C.prefecture     AS prefecture',
                            'RT.name          AS route_name',
                            'IC_SQ.CNT        AS i_cnt',
                            'REQ_SQ.name      AS req_stf',
                            'EST_SQ.name      AS est_stf',
                            'AGR_SQ.name      AS agr_stf',
                            'FIN_SQ.name      AS fin_stf',
                            'B_CNT.count      AS b_cnt',
                            'PRC.buy_price    AS buy_price',
                            'PRC.sell_price   AS sell_price',
                            'PRC.profit       AS profit',
                            'PRC.profit_rate  AS profit_rate',
                            'RD.updated_at    AS dt',
                            'RD.client_id     AS client_id'
                            )
                          ->leftJoin(DB::raw("(select request_id, max(progress_status)AS max_s from request_progresses where status <> 'X' group by request_id) AS RP_SQ"), 'RP_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, name  from items where (request_id, count) in (select request_id,min(count) from items where status <> 'X' group by request_id)) AS I_SQ"), 'I_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, count(*) AS CNT from items where status <> 'X' group by request_id) AS IC_SQ"), 'IC_SQ.request_id', '=', 'RD.request_id')
                          //@TODO 定数化
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['contact']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS REQ_SQ"), 'REQ_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['estimate']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS EST_SQ"), 'EST_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['agreement']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS AGR_SQ"), 'AGR_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['pay_complete']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS FIN_SQ"), 'FIN_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, count(*) AS count from items where (request_id) IN (select request_id created_dt from request_progresses where progress_status >=".$prg_nums['agreement']." group by request_id) AND status <> 'X' AND status <>'R' group by request_id) AS B_CNT"), 'B_CNT.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, SUM(buy_price) AS buy_price, SUM(sell_price) AS sell_price, SUM(sell_price)-SUM(buy_price) AS profit, (SUM(sell_price)-SUM(buy_price))/SUM(sell_price)*100 AS profit_rate from items where status <> 'X' and status <> 'R' group by request_id) AS PRC"), 'PRC.request_id', '=', 'RD.request_id')
                          ->leftJoin('clients AS C', 'C.id', '=', 'RD.client_id')
                          ->leftJoin('base_types AS BT', 'BT.id', '=', 'C.base')
                          ->leftJoin('routes AS RT', 'RT.id', '=', 'RD.route')
                          ->where('RD.status', '<>', 'X')
                          ->when($name, function ($query) use ($name) {
                            return $query->where('C.fullname', 'LIKE', '%'.$name.'%');
                          })
                          ->when($kana, function ($query) use ($kana) {
                            return $query->where('C.fullkana', 'LIKE', '%'.$kana.'%');
                          })
                          ->orderBy('RD.created_at', 'DESC')
                          ->paginate(5);
      return view('request.index', [
        'request_results' =>  $request_results,
        'name'            =>  $name,
        'kana'            =>  $kana,
        'urgencys'        =>  $urgencys,
        'prges'           =>  $prges,
        'buy_ways'        =>  $buy_ways,
        'prefs'           =>  $prefs
      ]);
  }

}
