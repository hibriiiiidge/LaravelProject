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

    $request_id = $request->reqdtl_id;
    $client_id  = $request->clt_id;
    $name       = $request->name;
    $kana       = $request->kana;
    $tel        = $request->tel;
    $fax        = $request->fax;
    $urgency    = $request->urgency;
    $base       = $request->base;
    $status     = $request->status;
    $buy_way    = $request->buy_way;
    $prefecture = $request->prefecture;
    $staff      = $request->staff;
    $rgst_from  = $request->rgst_from;
    $rgst_to    = $request->rgst_to;
    $fin_from   = $request->fin_from;
    $fin_to     = $request->fin_to;

    $searchCondition = compact(
      'request_id',
      'client_id',
      'name',
      'kana',
      'tel',
      'fax',
      'urgency',
      'base',
      'status',
      'buy_way',
      'prefecture',
      'staff',
      'rgst_from',
      'rgst_to',
      'fin_from',
      'fin_to'
    );
    $prg_nums   = config('progress_num');
    $urgencys   = config('urgency');
    $prges      = config('progress');
    $buy_ways   = config('buy_way');
    $prefs      = config('pref');
    $baseTypes  = DB::table('base_types')
                    ->where('status', '<>', 'X')
                    ->get();
    $staffs     = DB::table('users')
                    ->where('status', '<>', 'X')
                    ->get();
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
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name, U.id AS id from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['contact']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS REQ_SQ"), 'REQ_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name, U.id AS id from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['estimate']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS EST_SQ"), 'EST_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name, U.id AS id from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['agreement']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS AGR_SQ"), 'AGR_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select RPO.r_id AS request_id, RPO.created_at AS created_at, U.name AS name, U.id AS id from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = ".$prg_nums['pay_complete']." group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS FIN_SQ"), 'FIN_SQ.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, count(*) AS count from items where (request_id) IN (select request_id created_dt from request_progresses where progress_status >=".$prg_nums['agreement']." group by request_id) AND status <> 'X' AND status <>'R' group by request_id) AS B_CNT"), 'B_CNT.request_id', '=', 'RD.request_id')
                          ->leftJoin(DB::raw("(select request_id, SUM(buy_price) AS buy_price, SUM(sell_price) AS sell_price, SUM(sell_price)-SUM(buy_price) AS profit, (SUM(sell_price)-SUM(buy_price))/SUM(sell_price)*100 AS profit_rate from items where status <> 'X' and status <> 'R' group by request_id) AS PRC"), 'PRC.request_id', '=', 'RD.request_id')
                          ->leftJoin('clients AS C', 'C.id', '=', 'RD.client_id')
                          ->leftJoin('base_types AS BT', 'BT.id', '=', 'C.base')
                          ->leftJoin('routes AS RT', 'RT.id', '=', 'RD.route')
                          ->where('RD.status', '<>', 'X')
                          ->when($request_id, function ($query) use ($request_id) {
                            return $query->where('RD.request_id', '=', $request_id);
                          })
                          ->when($client_id, function ($query) use ($client_id) {
                            return $query->where('C.id', '=', $client_id);
                          })
                          ->when($name, function ($query) use ($name) {
                            return $query->where('C.fullname', 'LIKE', '%'.$name.'%');
                          })
                          ->when($kana, function ($query) use ($kana) {
                            return $query->where('C.fullkana', 'LIKE', '%'.$kana.'%');
                          })
                          ->when($tel, function ($query) use ($tel) {
                            return $query->where('C.tel', '=', $tel);
                          })
                          ->when($fax, function ($query) use ($fax) {
                            return $query->where('C.fax', '=', $fax);
                          })
                          ->when($urgency, function ($query) use ($urgency) {
                            return $query->where('RD.urgency', '=', $urgency);
                          })
                          ->when($base, function ($query) use ($base) {
                            return $query->where('C.base', '=', $base);
                          })
                          ->when($status, function ($query) use ($status) {
                            return $query->where('RP_SQ.max_s', '=', $status);
                          })
                          ->when($buy_way, function ($query) use ($buy_way) {
                            return $query->where('RD.buy_way', '=', $buy_way);
                          })
                          ->when($prefecture, function ($query) use ($prefecture) {
                            return $query->where('C.prefecture', '=', $prefecture);
                          })
                          ->when($staff, function ($query) use ($staff) {
                            return $query->where('REQ_SQ.id', '=', $staff);
                          })
                          ->when($rgst_from, function ($query) use ($rgst_from) {
                            return $query->whereDate('RD.created_at', '>=',$rgst_from);
                          })
                          ->when($rgst_to, function ($query) use ($rgst_to) {
                            return $query->whereDate('RD.created_at', '<=',$rgst_to);
                          })
                          ->when($fin_from, function ($query) use ($fin_from) {
                            return $query->whereDate('FIN_SQ.created_at', '>=',$fin_from);
                          })
                          ->when($fin_to, function ($query) use ($fin_to) {
                            return $query->whereDate('FIN_SQ.created_at', '<=',$fin_to);
                          })
                          ->orderBy('RD.created_at', 'DESC')
                          ->paginate(5);
      return view('request.index', [
        'request_results' =>  $request_results,
        'urgencys'        =>  $urgencys,
        'prges'           =>  $prges,
        'buy_ways'        =>  $buy_ways,
        'prefs'           =>  $prefs,
        'base_types'      =>  $baseTypes,
        'staffs'          =>  $staffs,
        'searchCondition' =>  $searchCondition,

        'request_id'      =>  $request_id,
        'client_id'       =>  $client_id,
        'name'            =>  $name,
        'kana'            =>  $kana,
        'tel'             =>  $tel,
        'fax'             =>  $fax,
        'urgency'         =>  $urgency,
        'base'            =>  $base,
        'status'          =>  $status,
        'buy_way'         =>  $buy_way,
        'prefecture'      =>  $prefecture,
        'staff'           =>  $staff,
        'rgst_from'       =>  $rgst_from,
        'rgst_to'         =>  $rgst_to,
        'fin_from'        =>  $fin_from,
        'fin_to'          =>  $fin_to
      ]);
  }
}
