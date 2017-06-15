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
                'RD.client_id   AS client_id',
                'C.name         AS c_name',
                'C.first_name   AS c_fname',
                'C.base         AS base',
                'RD.request_id  AS request_id',
                'RD.urgency     AS urgency',
                'RD.buy_way     AS buy_way',
                'SQ.max_s       AS latest_status',
                'RD.updated_at  AS dt'
                )
              ->leftJoin(DB::raw("(select request_id, max(progress_status)AS max_s from request_progresses group by request_id) AS SQ"), 'SQ.request_id', '=', 'RD.request_id')
              ->leftJoin('clients AS C', 'C.id', '=', 'RD.client_id')
              ->orderBy('RD.created_at', 'DESC')->get();
    //dd(DB::getQueryLog());
    // dd($requests);
    return view('request.index', ['requests'=>$requests]);
  }
}
