@extends('layouts.app')

@section('content')
<!-- search-bar-button -->
<div id="st-trigger-effects" class="column" style="text-align: right;float: right;">
  <button data-effect="st-effect-search" style="border-radius: 20px;"><i class="fa fa-search fa-2x"></i></button>
</div>
<div id="request_list_container">
  <div id="search_condition">
    <div id="search_contents">

    </div>
  </div>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>商品ID</th>
        <th>依頼ID</th>
        <th>進捗</th>
        <th>カテゴリー</th>
        <th>メーカー</th>
        <th>外観</th>
        <th>動作状況</th>
        <th>商品名</th>
        <th>買取価格</th>
        <th>販売価格</th>
        <th>粗利額</th>
        <th>粗利率</th>
        <th>更新日時</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($items_results as $ir)
        <tr>
          <td class="">
            <div class="">
              <a href="{{ action('ItemsController@edit', [$ir->i_id]) }}">{{ $ir->i_id }}</a>
            </div>
          </td>
          <td class="">
            <div class="">
              <a href="{{ action('ClientsController@edit', [$ir->c_id , $ir->r_id]) }}">{{ $ir->r_id }}</a>
            </div>
          </td>
          <td class="">
            <div class="">{{ $prges[$ir->p_status] }}</div>
          </td>
          <td class="">
            <div class="">{{ chkStr($ir->ic_name) }}</div>
          </td>
          <td class="">
            <div class="">{{ chkStr($ir->im_name) }}</div>
          </td>
          <td class="">
            <div class="">{{ $out_conds[$ir->o_cond] }}</div>
          </td>
          <td class="">
            <div class="">{{ $in_conds[$ir->i_cond] }}</div>
          </td>
          <td class="">
            <div class="">{{ chkStr($ir->i_name) }}</div>
          </td>
          <td class="">
            <div class="">{{ nf_TP($ir->buy_price) }}</div>
          </td>
          <td class="">
            <div class="">{{ nf_TP($ir->sell_price) }}</div>
          </td>
          <td class="">
            <div class="">{{ nf_TP($ir->profit) }}</div>
          </td>
          <td class="">
            <div class="">{{ chkRate($ir->profit_rate).'%' }}</div>
          </td>
          <td class="">
            <div class="">{{ chgDtFrmt($ir->updated_at) }}</div>
          </td>
        </tr>
      @empty
        <tr>
          <td>該当する案件はありません。</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  {{ $items_results->links() }}
</div>
@endsection

@section('search')
  @include('search.item_form_partial')
@endsection
