@extends('layouts.app')

@section('content')
<!-- search-bar-button -->
<div id="st-trigger-effects" class="column" style="text-align:right;">
  <button data-effect="st-effect-search">Scale down pusher</button>
</div>
<div id="request_list_container">
  <div class="">
    @if ($name)
      {{ $name }}
    @endif
    {{-- @if ($kana)
      {{ $kana }}
    @endif --}}
  </div>
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
        <th>最終確認</th>
        <th>完了</th>
        <th>買</th>
        <th>買取額</th>
        <th>販売額</th>
        <th>粗利額</th>
        <th>粗率</th>
        <th>更新日時</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($request_results as $rr)
        <tr>
          <th class="th_requestid">
            <div class="in_requestid">
              <a href="{{ action('ClientsController@edit', [$rr->client_id , $rr->request_id]) }}">{{ $rr->request_id }}</a>
            </div>
          </th>
          <td class="td_urgency">
            <div class="in_urgency">{{ $rr->urgency }}</div>
          </td>
          <td class="td_base">
            <div class="in_base">{{ $rr->base }}</div>
          </td>
          <td class="td_status">
            <div class="in_status">{{ $rr->latest_status }}</div>
          </td>
          <td class="td_buyway">
            <div class="in_buyway">{{ $rr->buy_way ? $rr->buy_way : '(未入)' }}</div>
          </td>
          <td class="td_cname">
            <div class="in_cname">{{ $rr->c_name." ".$rr->c_fname }}</div>
          </td>
          <td class="td_iname">
            <div class="in_iname">{{ $rr->i_name ? $rr->i_name : '(未入)' }}</div>
          </td>
          <td class="td_prefecture">
            <div class="in_prefecture">{{ $rr->prefecture ? $rr->prefecture : '(未入)' }}</div>
          </td>
          <td class="td_route">
            <div class="in_route">{{ $rr->route ? $rr->route : '(未入)' }}</div>
          </td>

          <td class="td_req_cnt">
            <div class="in_req_cnt">{{ $rr->i_cnt }}</div>
          </td>
          <td class="td_req_stf">
            <div class="in_req_stf">{{ $rr->req_stf }}</div>
          </td>
          <td class="td_est_stf">
            <div class="in_est_stf">{{ $rr->est_stf ? $rr->est_stf : '' }}</div>
          </td>
          <td class="td_agr_stf">
            <div class="in_agr_stf">{{ $rr->agr_stf ? $rr->agr_stf : '' }}</div>
          </td>
          <td class="td_fin_stf">
            <div class="in_fin_stf">{{ $rr->fin_stf ? $rr->fin_stf : '' }}</div>
          </td>
          <td class="td_buy_cnt">
            <div class="in_buy_cnt">{{ $rr->b_cnt ? $rr->b_cnt : '' }}</div>
          </td>
          <td class="td_buy_price">
            <div class="in_buy_price">{{ nf_TP($rr->buy_price) }}</div>
          </td>
          <td class="td_sell_price">
            <div class="in_sell_price">{{ nf_TP($rr->sell_price) }}</div>
          </td>
          <td class="td_profit">
            <div class="in_profit">{{ nf_TP($rr->profit) }}</div>
          </td>
          <td class="td_profit_rate">
            <div class="in_profit_rate">{{ $rr->profit_rate ? round($rr->profit_rate).'%': '-%'}}</div>
          </td>
          <td class="td_latest_dt">
            {{-- @TODO ヘルパー関数の定義 表記変更 --}}
            <div class="in_latest_dt">{{ $rr->dt }}</div>
          </td>
        </tr>
      @empty
        <tr>
          <td>該当する案件はありません。</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{-- $request_results->appends( ['name'=>$request_results['params']['name'] ])->links() --}}
  {{-- {{ $request_results->appends(['name'=>$name, 'kana'=>$kana])->links() }} --}}
</div>
@endsection

@section('search')
  @include('search.form_partial', ['name'=>$name])
@endsection
