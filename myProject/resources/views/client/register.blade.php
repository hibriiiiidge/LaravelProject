@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ action('ClientsController@store') }}">
  {{ csrf_field() }}
  {{-- <div class="">
      <button type="submit" class="btn btn-info" style="float:right;">
          検索
      </button>
  </div>
  <div class="">
    <input type="text" name="search" value="" width="100px" style="float:right;">
  </div>--}}
  <div id="new_rgst_btn">
      <button type="submit" class="btn btn-primary rgst_btn">
          登録
      </button>
  </div>
  <div id="select_tab">
      <ul class="nav nav-tabs" style="margin-bottom: -1.5px;">
          <li class="active"><a href="#client_tab" data-toggle="tab">顧客</a></li>
          <li><a href="#request_tab" data-toggle="tab">依頼</a></li>
          <li><a href="#item_tab" data-toggle="tab">商品</a></li>
          <li id="add_btn"><a href="#add_item_tab" id="add_item" data-toggle="tab">+追加</a></li>
      </ul>
  </div>
  <div id="wrap_main_container">
    <div id="myTabContent" class="tab-content" style="padding-top: 5px;border-top: 1px #eee solid;">
    <!--TAB CLIENT START-->
      <div class="tab-pane fade in active" id="client_tab">
          @include('client.client_partial')
      </div><!--TAB client END-->
      <div class="tab-pane fade" id="request_tab">
          @include('client.request_partial')
      </div><!--TAB request END-->
      <div class="tab-pane fade" id="item_tab">
          @include('client.item_partial')
      </div><!--TAB item END-->
    </div><!-- TAB All END -->
  </div><!-- #wrap_main_container -->
  <div id="progress_container">
    @include('client.progress_partial')
  </div>
  <div id="summary_container">
    @include('client.summary_partial')
  </div>
  <input type="hidden" name="memo_type" value="">
</form>
@endsection
