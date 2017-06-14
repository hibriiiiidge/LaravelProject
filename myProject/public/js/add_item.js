$(function(){

  //summary_memoのmainとsubのどちらを最後に編集したかを判定し、hiddenに値を持たせる処理
  $('.memo').focusout(function(e){
    $("input[name='memo_type']").val($(this).data('type'));
  });

  //Itemの入力フォームをDOMで生成する処理
  $('body').on('click', '#add_item', chkItem);
  //一つ前の商品入力フォームのカテゴリーが選択されていたら、次のフォームを生成可能
  function chkItem(){
      var trgtTab   = $("li#add_btn").prev(); //[追加]ボタンの一つ前のtabの要素を取得
      var trgtTabId = trgtTab.children('a').attr('href'); //a hrefタグで指定されているIDを取得
      var splitId   = trgtTabId.split("tab"); //タイムスタンプを取得
      var catVal    = $(trgtTabId+" #category"+splitId[1]).val(); //カテゴリーの値を取得
    if(catVal){
      addItem();
    }
  }
  //次の商品入力フォームを生成する処理
  function addItem(){
    var ts = $.now();
    // tab
    $('li#add_btn').before('<li id="item_li_tab_'+ts+'"><a href="#item_tab_'+ts+'" data-toggle="tab">商品</a></li>');

    // content
    $('#myTabContent').append(
      $("<div></div>", {Id:"item_tab_"+ts, addClass: "tab-pane fade"})
    );
    $("#item_tab_"+ts).prepend(
      $("<div></div>", {Id:"item_cont_"+ts, addClass: "item_container"})
    );
    $("#item_cont_"+ts).prepend(
      $("<div></div>", {Id:"item_panel_"+ts, addClass: "col-lg-12 item-panel"})
    );
    $("#item_panel_"+ts).prepend(
      $("<div></div>", {Id:"item_panel_def_"+ts, addClass: "panel panel-default"})
    );
    $("#item_panel_def_"+ts).prepend(
      $("<div></div>", {Id:"item_panel_body_"+ts, addClass: "panel-body"})
    );
    $("#item_panel_body_"+ts).prepend(
      $("<div></div>", {Id:"item_tbl_res_"+ts, addClass: "table-responsive"})
    );
    // table
    $("#item_tbl_res_"+ts).prepend(
      $("<table></table>", {Id:"item_request_table_"+ts, addClass: "table table-striped table-hover"})
    );
    $("#item_request_table_"+ts).prepend(
      $("<tbody></tbody>")
    );
        //category
        $("#item_request_table_"+ts+">tbody").prepend(
          $("<tr></tr>", {Id:"item_cat_"+ts, addClass: "form-group"})
        );
            $("#item_cat_"+ts).append(
              $("<th></th>")
            );
            $("#item_cat_"+ts).append(
              $("<td></td>")
            );
                $("#item_cat_"+ts+">th").prepend(
                  '<label for="category" class="col-lg-12 control-label">カテゴリー</label>'
                );
                $("#item_cat_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#item_cat_"+ts+">td>div").prepend(
                  $("<select></select>", {Id:"category_"+ts, addClass: "form-control", name:"category[]"})
                );
                $("#category_"+ts).prepend(
                  '<option value="">未選択</option>'+
                  '<option value="1">パソコン</option>'+
                  '<option value="2">オーディオ</option>'+
                  '<option value="3">カメラ</option>'
                );
        //item_name
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"item_name_"+ts, addClass: "form-group"})
        );
            $("#item_name_"+ts).append(
              $("<th></th>")
            );
            $("#item_name_"+ts).append(
              $("<td></td>")
            );
                $("#item_name_"+ts+">th").prepend(
                  '<label for="category" class="col-lg-12 control-label">商品名</label>'
                );
                $("#item_name_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#item_name_"+ts+">td>div").prepend(
                  '<input id="item_name" type="text" class="form-control" name="item_name[]">'
                );
        //outside_condition
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"outside_condition_"+ts, addClass: "form-group"})
        );
            $("#outside_condition_"+ts).append(
              $("<th></th>")
            );
            $("#outside_condition_"+ts).append(
              $("<td></td>")
            );
                $("#outside_condition_"+ts+">th").prepend(
                  '<label for="outside_condition" class="col-lg-12 control-label">外観の状態</label>'
                );
                $("#outside_condition_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#outside_condition_"+ts+">td>div").prepend(
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="0" checked>未確認' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="1">新品' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="2">ほぼ新品' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="3">非常に良い' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="4">良い' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="5">可' +
                  '<input type="radio" class="outside_condition" name="outside_condition['+ts+']" value="6">難あり'
                );
        //inside_condition
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"inside_condition_"+ts, addClass: "form-group"})
        );
            $("#inside_condition_"+ts).append(
              $("<th></th>")
            );
            $("#inside_condition_"+ts).append(
              $("<td></td>")
            );
                $("#inside_condition_"+ts+">th").prepend(
                  '<label for="inside_condition" class="col-lg-12 control-label">動作状況</label>'
                );
                $("#inside_condition_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#inside_condition_"+ts+">td>div").prepend(
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="0" checked>未確認' +
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="1">保証品' +
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="2">未開封品' +
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="3">未使用品' +
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="4">現状品' +
                  '<input type="radio" class="inside_condition" name="inside_condition['+ts+']" value="5">ジャンク品'
                );
        //cooling_off_flg
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"cooling_off_flg_"+ts, addClass: "form-group"})
        );
            $("#cooling_off_flg_"+ts).append(
              $("<th></th>")
            );
            $("#cooling_off_flg_"+ts).append(
              $("<td></td>")
            );
                $("#cooling_off_flg_"+ts+">th").prepend(
                  '<label for="cooling_off_flg" class="col-lg-12 control-label">クーリングオフの有無</label>'
                );
                $("#cooling_off_flg_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#cooling_off_flg_"+ts+">td>div").prepend(
                  '<input type="radio" class="cooling_off_flg" name="cooling_off_flg['+ts+']" value="0" checked>未確認' +
                  '<input type="radio" class="cooling_off_flg" name="cooling_off_flg['+ts+']" value="1">対象' +
                  '<input type="radio" class="cooling_off_flg" name="cooling_off_flg['+ts+']" value="2">対象外'
                );
        //item_name
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"item_memo_"+ts, addClass: "form-group"})
        );
            $("#item_memo_"+ts).append(
              $("<th></th>")
            );
            $("#item_memo_"+ts).append(
              $("<td></td>")
            );
                $("#item_memo_"+ts+">th").prepend(
                  '<label for="item_memo" class="col-lg-12 control-label">特記事項</label>'
                );
                $("#item_memo_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#item_memo_"+ts+">td>div").prepend(
                  '<textarea name="item_memo['+ts+']" rows="8" cols="80" id="item_memo"></textarea>'
                );
    $("#item_tbl_res_"+ts).prepend(
      $("<div></div>", {Id:"item_hidden_"+ts, addClass: "item_hidden"})
    );
    $("#item_tab_"+ts).append(
      $("<div></div>", {Id:"item_delete_"+ts, addClass: "delete_btn"})
    );
        $("#item_delete_"+ts).prepend(
          '<button type="button" id="delete_btn_'+ts+'" class="btn btn-danger">削除</button>'
        );
  }

  //削除ボタンがクリックされたた対象のタブを削除する処理
  $('body').on('click', '.delete_btn', deleteTab);
  function deleteTab(){
    if(confirm('商品情報を削除しますか？')){
      //idからタイムスタンプを取得
      var deleteId = $(this).attr('id');
      var splitTs  = deleteId.split("delete");
      //１つ前のliをactive状態に変更し、ターゲットのliを削除
      var preLi = $("#item_li_tab"+splitTs[1]).prev();
      $(preLi).addClass('active');
      $("#item_li_tab"+splitTs[1]).remove();
      //１つ前のtabを"active in"状態に変更し、ターゲットのitem_tabを削除(逆ではNG)
      var preTab = $("#item_tab"+splitTs[1]).prev();
      $(preTab).addClass('active in');
      $("#item_tab"+splitTs[1]).remove();
    }
  }

});
