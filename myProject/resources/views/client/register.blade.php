@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ action('ClientsController@store') }}">
  {{ csrf_field() }}
  <div class="">
      <button type="submit" class="btn btn-info" style="float:right;">
          検索
      </button>
  </div>
  <div class="">
    <input type="text" name="search" value="" width="100px" style="float:right;">
  </div>
  <div id="rgst_btn">
      <button type="submit" class="btn btn-primary">
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
          @include('client.client_partial', ['client'=>$client])
      </div><!--TAB client END-->
      <div class="tab-pane fade" id="request_tab">
          @include('client.request_partial', ['requestDetail'=>$requestDetail])
      </div><!--TAB request END-->
      <div class="tab-pane fade" id="item_tab">
          @include('client.item_partial')
      </div><!--TAB item END-->
    </div><!-- TAB All END -->
  </div><!-- #wrap_main_container -->
  <div id="progress_container">
    <div class="progress_block">
      <label for="progress_status">進捗状況</label>
      <select id="progress_status" name="progress_status">
        <option value="1">要返信</option>
        <option value="2">見積済</option>
        <option value="3">交渉中</option>
        <option value="4">荷着待</option>
      </select>
      <textarea name="progress_memo" rows="3" placeholder="伝達事項" id="progress_memo"></textarea>
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
              <li>拠点:</li>
              <li>性別：</li>
              <li>電話番号:</li>
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
            <textarea name="summary_memo_sub" rows="8" id="summary_memo_sub" class="memo" data-type="sub"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="memo_type" value="">
</form>
<script type="text/javascript">
  $(function(){
    //summary_memoのmainとsubのどちらを最後に編集したかを判定し、hiddenに値を持たせる処理
    $('.memo').focusout(function(e){
      $("input[name='memo_type']").val($(this).data('type'));
    });

    $('body').on('click', '#add_item', addItem);

    function addItem(){
      $('li#add_btn').before('<li><a href="#item2_tab" data-toggle="tab">商品2</a></li>');
      $('#item_tab').after(
        $("<div></div>", {Id:"item2_tab", addClass: "tab-pane fade"})
      );
      $("#item2_tab").prepend(
        $("<div></div>", {Id:"item2_cont", addClass: "item_container"})
      );
      $("#item2_cont").prepend(
        $("<div></div>", {Id:"item2_panel", addClass: "col-lg-12 item-panel"})
      );
      $("#item2_panel").prepend(
        $("<div></div>", {Id:"item2_panel_def", addClass: "panel panel-default"})
      );
      $("#item2_panel_def").prepend(
        $("<div></div>", {Id:"item2_panel_body", addClass: "panel-body"})
      );
      $("#item2_panel_body").prepend(
        $("<div></div>", {Id:"item2_tbl_res", addClass: "table-responsive"})
      );
      $("#item2_tbl_res").prepend(
        $("<table></table>", {Id:"item2_request_table", addClass: "table table-striped table-hover"})
      );
      $("#item2_request_table").prepend(
        $("<tbody></tbody>")
      );
      $("#item2_request_table>tbody").prepend(
        $("<tr></tr>", {Id:"item2_cat", addClass: "form-group"})
      );
          $("#item2_cat").append(
            $("<th></th>")
          );
          $("#item2_cat").append(
            $("<td></td>")
          );
              $("#item2_cat>th").prepend(
                '<label for="category" class="col-lg-12 control-label">カテゴリー</label>'
              );
              $("#item2_cat>td").prepend(
                $("<div></div>", {addClass: "col-lg-12"})
              );
              $("#item2_cat>td>div").prepend(
                $("<select></select>", {Id:"item2_category", addClass: "form-control", name:"category"})
              );
              $("#item2_category").prepend(
                '<option value="">未選択</option><option value="1">パソコン</option><option value="2">オーディオ</option><option value="3">カメラ</option>'
              );
      $("#item2_request_table>tbody").append(
        $("<tr></tr>", {Id:"item2_name", addClass: "form-group"})
      );
          $("#item2_name").append(
            $("<th></th>")
          );
          $("#item2_name").append(
            $("<td></td>")
          );
              $("#item2_name>th").prepend(
                '<label for="category" class="col-lg-12 control-label">商品名</label>'
              );
              $("#item2_name>td").prepend(
                $("<div></div>", {addClass: "col-lg-12"})
              );
              $("#item2_name>td>div").prepend(
                '<input id="item_name" type="text" class="form-control" name="item_name">'
              );

      $("#item2_tbl_res").prepend(
        $("<div></div>", {Id:"item2_item_hidden", addClass: "item_hidden"})
      );

    }

  });
</script>
@endsection
