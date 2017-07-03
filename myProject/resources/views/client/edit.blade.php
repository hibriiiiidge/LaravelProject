@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action=" {{ action('ClientsController@update', [$client->id, $requestDetail->request_id]) }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  <div class="hidden_items">
    <input type="hidden" name="status" value="◯">
    <input type="hidden" name="rgster" value="{{ Auth::user()->id }}">
    <input type="hidden" name="updter" value="{{ Auth::user()->id }}">
  </div>
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
          @if ($latestSts < $prg_nums['final_price'])
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
    @include('client.progress_partial')
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
    @include('client.summary_partial')
  </div>
  <input type="hidden" name="memo_type" value="">
</form>
<form action="{{ action('ClientsController@destroy', [$client->id, $requestDetail->request_id]) }}" method="post" id="deleteTabForm">
  {{ csrf_field() }}
  {{ method_field('delete') }}
  <input type="hidden" name="deleteItemGroup" id="deleteItemGroup" value="">
</form>
@endsection
