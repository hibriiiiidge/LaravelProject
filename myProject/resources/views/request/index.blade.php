@extends('layouts.app')

@section('content')
<!-- search-bar-button -->
<div id="st-trigger-effects" class="column" style="text-align: right;float: right;">
  <button data-effect="st-effect-search" style="border-radius: 20px;"><i class="fa fa-search fa-2x"></i></button>
</div>
<div id="request_list_container">
  <div id="$search_condition">
    @if ($isEmpty)
      <div id="search_title">
        検索条件
      </div>
    @endif
    <div id="search_contents">
      <ul>
    {{-- @foreach ($search_condition as $key => $value) --}}
          @php
          foreach ($search_condition as $key => $value) {
            if($value){
              switch ($key) {
                case 'urgency':
                  echo "<li class='search_conditions s_u'> $search_title[$key] : $urgencys[$value] </li>";
                  break;
                case 'base':
                  echo "<li class='search_conditions s_b'> $search_title[$key] : $value </li>";
                  break;
                case 'buy_way':
                  echo "<li class='search_conditions s_bw'> $search_title[$key] : $buy_ways[$value] </li>";
                  break;
                case 'status':
                  echo "<li class='search_conditions s_sts'> $search_title[$key] : $prges[$value] </li>";
                  break;
                case 'prefecture':
                  echo "<li class='search_conditions s_pref'> $search_title[$key] : $prefs[$value] </li>";
                  break;
                case 'staff':
                  echo "<li class='search_conditions s_stf'> $search_title[$key] : $value </li>";
                  break;
                case 'rgst_to':
                case 'fin_to':
                  echo "<li class='search_conditions s_to'> $search_title[$key] $value </li>";
                  break;
                default:
                  echo "<li class='search_conditions'> $search_title[$key] : $value </li>";
                  break;
              }
            }
          }
          @endphp
          {{-- @if($key=='rgst_to' || $key=='fin_to')
              <li class="search_to">{{ $search_title[$key] }}{{ $value }}</li>
          @else
              <li class="search_conditions">{{ $search_title[$key] }} :  {{ $value }}</li>
          @endif --}}
      {{-- @endforeach --}}
      </ul>
    </div>
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
            <div class="in_urgency">{{ $rr->urgency ? $urgencys[$rr->urgency]:'-' }}</div>
          </td>
          <td class="td_base">
            <div class="in_base">{{ $rr->base_name }}</div>
          </td>
          <td class="td_status">
            <div class="in_status">{{ $prges[$rr->latest_status] }}</div>
          </td>
          <td class="td_buyway">
            <div class="in_buyway">{{ $rr->buy_way ? $buy_ways[$rr->buy_way]:'-' }}</div>
          </td>
          <td class="td_cname">
            <div class="in_cname">{{ $rr->c_name." ".$rr->c_fname }}</div>
          </td>
          <td class="td_iname">
            <div class="in_iname">{{ chkStr($rr->i_name) }}</div>
          </td>
          <td class="td_prefecture">
            <div class="in_prefecture">{{ $rr->prefecture ? $prefs[$rr->prefecture]:'-' }}</div>
          </td>
          <td class="td_route">
            <div class="in_route">{{ chkStr($rr->route_name) }}</div>
          </td>

          <td class="td_req_cnt">
            <div class="in_req_cnt">{{ chkStr($rr->i_cnt) }}</div>
          </td>
          <td class="td_req_stf">
            <div class="in_req_stf">{{ chkStr($rr->req_stf) }}</div>
          </td>
          <td class="td_est_stf">
            <div class="in_est_stf">{{ chkStr($rr->est_stf) }}</div>
          </td>
          <td class="td_agr_stf">
            <div class="in_agr_stf">{{ chkStr($rr->agr_stf) }}</div>
          </td>
          <td class="td_fin_stf">
            <div class="in_fin_stf">{{ chkStr($rr->fin_stf) }}</div>
          </td>
          <td class="td_buy_cnt">
            <div class="in_buy_cnt">{{ chkStr($rr->b_cnt) }}</div>
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
            <div class="in_profit_rate">{{ chkRate($rr->profit_rate).'%' }}</div>
          </td>
          <td class="td_latest_dt">
            {{-- @TODO ヘルパー関数の定義 表記変更 --}}
            <div class="in_latest_dt">{{ chgDtFrmt($rr->dt) }}</div>
          </td>
        </tr>
      @empty
        <tr>
          <td>該当する案件はありません。</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{-- @TODO 検索条件をコンテナ化して一気に渡したい... --}}
  {{ $request_results->appends([
    'request_id'  => $request_id,
    'client_id'   => $client_id,
    'name'        => $name,
    'kana'        => $kana,
    'tel'         => $tel,
    'fax'         => $fax,
    'urgency'     => $urgency,
    'base'        => $base,
    'status'      => $status,
    'buy_way'     => $buy_way,
    'prefecture'  => $prefecture,
    'staff'       => $staff,
    'rgst_from'   => $rgst_from,
    'rgst_to'     => $rgst_to,
    'fin_from'    => $fin_from,
    'fin_to'      => $fin_to
      ])->links() }}
</div>
@endsection

@section('search')
  @include('search.form_partial', [
    'old_request_id'  => $request_id,
    'old_client_id'   => $client_id,
    'old_name'        => $name,
    'old_kana'        => $kana,
    'old_tel'         => $tel,
    'old_fax'         => $fax,
    'old_urgency'     => $urgency,
    'old_base'        => $base,
    'old_status'      => $status,
    'old_buy_way'     => $buy_way,
    'old_prefecture'  => $prefecture,
    'old_staff'       => $staff,
    'old_rgst_from'   => $rgst_from,
    'old_rgst_to'     => $rgst_to,
    'old_fin_from'    => $fin_from,
    'old_fin_to'      => $fin_to
  ])
@endsection
