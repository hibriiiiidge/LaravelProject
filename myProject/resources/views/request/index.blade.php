@extends('layouts.app')

@section('content')
<div id="request_list_container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>依頼ID</th>
        <th>緊</th>
        <th>拠点</th>
        <th>状況</th>
        <th>買取</th>
        <th>氏名</th>
        <th>商品</th>
        <th>県</th>
        <th>サイト</th>
        <th>依</th>
        <th>受付</th>
        <th>見積済</th>
        <th>不明</th>
        <th>不明</th>
        <th>買</th>
        <th>買取額</th>
        <th>販売額</th>
        <th>粗利額</th>
        <th>粗率</th>
        <th>更新日時</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($requests as $request)
        <tr>
          <th class="th_requestid">
            <div class="in_requestid">
              <a href="{{ action('ClientsController@edit', [$request->client_id , $request->request_id]) }}">{{ $request->request_id }}</a>
            </div>
          </th>
          <td class="td_urgency">
            <div class="in_urgency">{{ $request->urgency }}</div>
          </td>
          <td class="td_base">
            <div class="in_base">{{ $request->base }}</div>
          </td>
          <td class="td_status">
            <div class="in_status">{{ $request->latest_status }}</div>
          </td>
          <td class="td_buyway">
            <div class="in_buyway">{{ $request->buy_way ? $request->buy_way : '(未入)' }}</div>
          </td>
          <td class="td_cname">
            <div class="in_cname">{{ $request->c_name." ".$request->c_fname }}</div>
          </td>
          <td class="td_iname">
            <div class="in_iname">Apple macbook pro 13 black</div>
          </td>
          <td class="td_prefecture">
            <div class="in_prefecture">神奈川県</div>
          </td>
          <td class="td_route">
            <div class="in_route">PC専門サイト</div>
          </td>

          <td class="td_req_cnt">
            <div class="in_req_cnt">2</div>
          </td>
          <td class="td_req_stf">
            <div class="in_req_stf">宮田 太郎</div>
          </td>
          <td class="td_est_stf">
            <div class="in_est_stf">中川 太郎</div>
          </td>
          <td class="td_xxx_stf">
            <div class="in_xxx_stf">玉城 太郎</div>
          </td>
          <td class="td_yyy_stf">
            <div class="in_yyy_stf">宮坂 太郎</div>
          </td>
          <td class="td_buy_cnt">
            <div class="in_buy_cnt">2</div>
          </td>
          <td class="td_buy_price">
            <div class="in_buy_price">100,000</div>
          </td>
          <td class="td_sell_price">
            <div class="in_sell_price">200,000</div>
          </td>
          <td class="td_profit">
            <div class="in_profit">100,000</div>
          </td>
          <td class="td_profit_rate">
            <div class="in_profit_rate">50%</div>
          </td>
          <td class="td_latest_dt">
            <div class="in_latest_dt">{{ $request->dt }}</div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
