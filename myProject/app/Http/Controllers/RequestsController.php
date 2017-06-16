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
  public function index(){
    //DB::enableQueryLog();
    $requests = DB::table('request_details AS RD')
              ->select(
                'RD.client_id     AS client_id',
                'C.name           AS c_name',
                'C.first_name     AS c_fname',
                'C.base           AS base',
                'RD.request_id    AS request_id',
                'RD.urgency       AS urgency',
                'RD.buy_way       AS buy_way',
                'RP_SQ.max_s      AS latest_status',
                'I_SQ.name        AS i_name',
                'C.prefecture     AS prefecture',
                'RD.route         AS route',
                'IC_SQ.CNT        AS i_cnt',
                'REQ_SQ.name      AS req_stf',
                'EST_SQ.name      AS est_stf',
                'AGR_SQ.name      AS agr_stf',
                'FIN_SQ.name      AS fin_stf',
                'B_CNT.count      AS b_cnt',
                'RD.updated_at    AS dt'
                )
              ->leftJoin(DB::raw("(select request_id, max(progress_status)AS max_s from request_progresses where status <> 'X' group by request_id) AS RP_SQ"), 'RP_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select request_id, name  from items where (request_id, count) in (select request_id,min(count) from items where status <> 'X' group by request_id)) AS I_SQ"), 'I_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select request_id, count(*) AS CNT from items where status <> 'X' group by request_id) AS IC_SQ"), 'IC_SQ.request_id', '=', 'RD.request_id')
              //@TODO 定数化
              ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = 1 group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS REQ_SQ"), 'REQ_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = 2 group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS EST_SQ"), 'EST_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = 6 group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS AGR_SQ"), 'AGR_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select RPO.r_id AS request_id, U.name AS name from (select RP.request_id AS r_id, RP.created_at, RP.rgster AS rgster  FROM request_progresses AS RP WHERE (RP.request_id, created_at) IN (select request_id, MAX(created_at) AS created_dt from request_progresses where progress_status = 7 group by request_id)) AS RPO LEFT JOIN users AS U ON U.id = RPO.rgster) AS FIN_SQ"), 'FIN_SQ.request_id', '=', 'RD.request_id')
              ->leftJoin(DB::raw("(select request_id, count(*) AS count from items where (request_id) IN (select request_id created_dt from request_progresses where progress_status >=6 group by request_id) AND status <> 'X' AND status <>'R' group by request_id) AS B_CNT"), 'B_CNT.request_id', '=', 'RD.request_id')
              ->leftJoin('clients AS C', 'C.id', '=', 'RD.client_id')
              ->where('RD.status', '<>', 'X')
              ->orderBy('RD.created_at', 'DESC')
              ->get();
    //dd(DB::getQueryLog());
    //dd($requests);
    return view('request.index', ['requests'=>$requests]);
  }
}
