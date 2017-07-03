@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ action('ItemsController@update', $item->i_id) }}">
  {{ csrf_field() }}
  {{ method_field('patch') }}
  <div class="hidden_items">
    <input type="hidden" name="status" value="◯">
    <input type="hidden" name="rgster" value="{{ Auth::user()->id }}">
    <input type="hidden" name="updter" value="{{ Auth::user()->id }}">
  </div>
  <div id="edit_rgst_btn">
      <button type="submit" class="btn btn-primary rgst_btn">
          登録
      </button>
  </div>
  <div id="select_tab">
      <ul class="nav nav-tabs" style="margin-bottom: -1.5px;">
        <li class="active">
          <a href="#item_tab" data-toggle="tab">商品</a>
        </li>
      </ul>
  </div>
  <div id="wrap_main_container">
    <div id="myTabContent" class="tab-content" style="padding-top: 5px;border-top: 1px #eee solid;">
        <div class="tab-pane fade in active" id="item_tab">
          <div id="item_detail_container" class="item_container">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="table-responsive" style="clear:both;">
                    <table class="table table-striped table-hover" id="request_table">
                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">商品ID</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $item->i_id }}</span>
                          </div>
                        </td>

                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">依頼ID</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $item->r_id }}</span>
                          </div>
                        </td>
                      </tr>

                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">カテゴリー</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $item->ic_name }}</span>
                          </div>
                        </td>
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">メーカー</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $item->im_name }}</span>
                          </div>
                        </td>
                      </tr>

                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">商品名</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $item->i_name }}</span>
                          </div>
                        </td>
                        <td>
                          <label for="category" class="col-lg-3 control-label">COの有無</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $cooling_offs[$item->cooling_off_flg] }}</span>
                          </div>
                        </td>
                      </tr>

                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">外観の状態</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $out_conds[$item->o_cond] }}</span>
                          </div>
                        </td>
                        <td>
                          <label for="category" class="col-lg-3 control-label">動作状況</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ $in_conds[$item->i_cond] }}</span>
                          </div>
                        </td>
                      </tr>

                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">見積提示額</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ nf_TP($item->estimate_price) }}円</span>
                          </div>
                        </td>
                        <td>
                          <label for="category" class="col-lg-3 control-label">買取額</label>
                          <div class="col-lg-9">
                            <span class="i_detail">{{ nf_TP($item->buy_price) }}円</span>
                          </div>
                        </td>
                      </tr>

                      <tr id="buy_price_form" class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">出品額</label>
                          <div class="col-lg-4">
                            <input id="start_price"  type="text" class="form-control price" name="start_price" value="{{ $item->start_price }}">
                          </div>
                          <span class="yen">円</span>
                        </td>
                      </tr>

                      <tr id="buy_price_form" class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">落札予想額</label>
                          <div class="col-lg-4">
                            <input id="expsell_price"  type="text" class="form-control price" name="expsell_price" value="{{ $item->expsell_price }}">
                          </div>
                          <span class="yen">円</span>
                        </td>
                      </tr>

                      <tr id="buy_price_form" class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">落札額</label>
                          <div class="col-lg-4">
                            <input id="sell_price"  type="text" class="form-control price" name="sell_price" value="{{ $item->sell_price }}">
                          </div>
                          <span class="yen">円</span>
                        </td>
                      </tr>

                      <tr class="form-group item_form">
                        <td class="col-lg-6">
                          <label for="category" class="col-lg-3 control-label">粗利額</label>
                          <div class="col-lg-9">
                            <span class="i_detail">1,0000円</span>
                          </div>
                        </td>
                        <td>
                          <label for="category" class="col-lg-3 control-label">粗利率</label>
                          <div class="col-lg-9">
                            <span class="i_detail">20%</span>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--TAB item END-->
    </div><!-- TAB All END -->
  </div><!-- #wrap_main_container -->
  <div id="progress_container">
    @include('item.progress_partial')
    <div class="progress_table">
      <table class="table table-striped table-hover">
        <tbody>
          @forelse($iProgresses as $iProgress)
            <tr>
              <th>
                {{ $iProgress->dt }}
              </th>
              <td>
                {{ $i_prges[$iProgress->status] }}<br/>
                <span>{{ $iProgress->memo ? $iProgress->memo :"(伝達事項なし)" }}</span><br/>
                <span>{{ $iProgress->name }}</span>
              </td>
            </tr>
          @empty
            <tr>
              No comment
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div id="summary_container">
    @include('item.summary_partial')
  </div>
</form>
@endsection
