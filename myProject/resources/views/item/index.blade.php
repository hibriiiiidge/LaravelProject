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
        @php
        foreach ($search_condition as $key => $value) {
          if($value){
            switch ($key) {
              case 'progress':
                echo "<li class='search_conditions is_p'> $i_search_title[$key] : $i_prges[$value] </li>";
                break;
              case 'category_no':
                foreach ($categories as $category) {
                  if($category->id == $value){
                    echo "<li class='search_conditions is_c'> $i_search_title[$key] : $category->name </li>";
                  }
                }
                break;
              case 'maker_no':
                foreach ($makers as $maker) {
                  if($maker->id == $value){
                    echo "<li class='search_conditions is_m'> $i_search_title[$key] : $maker->name </li>";
                  }
                }
                break;
              default:
                echo "<li class='search_conditions'> $i_search_title[$key] : $value </li>";
                break;
            }
          }
        }
        @endphp
      </ul>
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
            <div class="">{{ $i_prges[$ir->ip_status] }}</div>
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
  {{ $items_results->appends([
    'request_id'  => $request_id,
    'item_name'   => $item_name,
    'progress'    => $progress,
    'category_no' => $category_no,
    'maker_no'    => $maker_no
      ])->links() }}
</div>
@endsection

@section('search')
  @include('search.item_form_partial',[
    'old_request_id'  => $request_id,
    'old_item_name'   => $item_name,
    'old_progress'    => $progress,
    'old_category'    => $category_no,
    'old_maker'       => $maker_no
  ])
@endsection
