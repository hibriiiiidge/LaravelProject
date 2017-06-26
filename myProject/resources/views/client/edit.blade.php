@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action=" {{ action('ClientsController@update', [$client->id, $requestDetail->request_id]) }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  {{-- <div class="">
      <button type="submit" class="btn btn-info" style="float:right;">
          検索
      </button>
  </div>
  <div class="">
    <input type="text" name="search" value="" width="100px" style="float:right;">
  </div>--}}
  <div id="edit_rgst_btn">
      <button type="submit" class="btn btn-primary rgst_btn">
          登録
      </button>
  </div>
  <div id="select_tab">
      <ul class="nav nav-tabs" style="margin-bottom: -1.5px;">
          <li class="active"><a href="#client_tab" data-toggle="tab">顧客</a></li>
          <li><a href="#request_tab" data-toggle="tab">依頼</a></li>
          @foreach ($items as $item)
            <li>
              <a href="#item_tab_{{ $item->no_underscore_id }}" data-toggle="tab">商品</a>
            </li>
          @endforeach
          @if ($latestSts< $prg_nums['finnal_price'])
            <li id="add_btn"><a href="#add_item_tab" id="add_item" data-toggle="tab">+追加</a></li>
          @endif
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
      @foreach ($items as $item)
        <div class="tab-pane fade" id="item_tab_{{ $item->no_underscore_id }}">
            @include('client.item_partial')
        </div><!--TAB item END-->
      @endforeach
    </div><!-- TAB All END -->
  </div><!-- #wrap_main_container -->
  <div id="progress_container">
    <div class="progress_block">
      <label for="progress_status">進捗状況</label>
      <select id="progress_status" name="progress_status">
        @foreach ($prges as $index => $prg)
          <option value="{{ $index }}" {{ $latestSts == $index ? 'selected' : '' }}>{{ $prg }}</option>
        @endforeach
      </select>
      <textarea name="progress_memo" rows="3" placeholder="伝達事項" id="progress_memo"></textarea>
    </div>
    <div class="progress_table">
      <table class="table table-striped table-hover">
        <tbody>
          @foreach ($rProgresses as $rProgress)
            <tr>
              <th>
                {{ $rProgress->dt }}
              </th>
              <td>
                {{ $prges[$rProgress->status] }}<br/>
                <span>{{ $rProgress->memo ? $rProgress->memo :"(伝達事項なし)" }}</span><br/>
                <span>{{ $rProgress->name }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div id="summary_container">
    <!-- ここからアコーディオン（Collapse） -->
    <div class="panel-group" id="" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="" href="#summary_tab" aria-expanded="true" aria-controls="collapseOne">
              サマリー
            </a>
          </h4>
        </div>
        <div id="summary_tab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <ul>
              <li>拠点：{{ $client->base }}</li>
              <li>名前：{{ $client->fullname }}</li>
              <li>電話番号:{{ $client->tel }}</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="" href="#summary_memo_tab" aria-expanded="false" aria-controls="collapseTwo">
              管理者メモ
            </a>
          </h4>
        </div>
        <div id="summary_memo_tab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body">
            <textarea name="summary_memo_sub" rows="8" id="summary_memo_sub" class="memo" data-type="sub">{{  old('summary_memo_sub', $requestDetail->summary_memo) }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="memo_type" value="">
</form>
<form action="{{ action('ClientsController@destroy', [$client->id, $requestDetail->request_id]) }}" method="post" id="deleteTabForm">
  {{ csrf_field() }}
  {{ method_field('delete') }}
  <input type="hidden" name="deleteItemId" id="deleteItemId" value="">
</form>
@endsection
