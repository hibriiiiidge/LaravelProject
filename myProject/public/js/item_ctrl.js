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
                  $("<select></select>", {Id:"category_"+ts, addClass: "form-control select_cat", name:"category[]"})
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
        //item_memo
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
        //estimate_price
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"dom_estimate_price_"+ts, addClass: "form-group"})
        );
            $("#dom_estimate_price_"+ts).append(
              $("<th></th>")
            );
            $("#dom_estimate_price_"+ts).append(
              $("<td></td>")
            );
                $("#dom_estimate_price_"+ts+">th").prepend(
                  '<label for="estimate_price" class="col-lg-12 control-label">見積提示額</label>'
                );
                $("#dom_estimate_price_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-2 tr_price"})
                );
                $("#dom_estimate_price_"+ts+">td>div").prepend(
                  '<input id="estimate_price_'+ts+'" type="text" class="form-control price estimate_price" name="estimate_price[]">'
                );
                $("#dom_estimate_price_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
        //expsell_min_price, expsell_max_price
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"expsell_price_"+ts, addClass: "form-group"})
        );
            $("#expsell_price_"+ts).append(
              $("<th></th>")
            );
            $("#expsell_price_"+ts).append(
              $("<td></td>")
            );
                $("#expsell_price_"+ts+">th").prepend(
                  '<label for="expsell_price" class="col-lg-12 control-label">見込販売額</label>'
                );
                $("#expsell_price_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-2 tr_price"})
                );
                $("#expsell_price_"+ts+">td>div").prepend(
                  '<input id="expsell_min_price_'+ts+'" type="text" class="form-control price expsell_min_price" name="expsell_min_price[]">'
                );
                $("#expsell_price_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
                $("#expsell_price_"+ts+">td").append(
                  '<div class="price wave">〜</div>'
                );
                $("#expsell_price_"+ts+">td").append(
                  $("<div></div>", {addClass: "col-lg-2 tr_price max_price"})
                );
                $("#expsell_price_"+ts+">td>div.max_price").prepend(
                  '<input id="expsell_max_price_'+ts+'" type="text" class="form-control price expsell_max_price" name="expsell_max_price[]">'
                );
                $("#expsell_price_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
        //exp_min_profit, exp_max_profit
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"exp_profit_"+ts, addClass: "form-group"})
        );
            $("#exp_profit_"+ts).append(
              $("<th></th>")
            );
            $("#exp_profit_"+ts).append(
              $("<td></td>")
            );
                $("#exp_profit_"+ts+">th").prepend(
                  '<label for="exp_profit" class="col-lg-12 control-label">見込粗利額</label>'
                );
                $("#exp_profit_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-2 tr_price"})
                );
                $("#exp_profit_"+ts+">td>div").prepend(
                  '<input id="exp_min_profit_'+ts+'" type="text" class="form-control price exp_min_profit" name="exp_min_profit[]">'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<div class="price wave">〜</div>'
                );
                $("#exp_profit_"+ts+">td").append(
                  $("<div></div>", {addClass: "col-lg-2 tr_price max_price"})
                );
                $("#exp_profit_"+ts+">td>div.max_price").prepend(
                  '<input id="exp_max_profit_'+ts+'" type="text" class="form-control price exp_max_profit" name="exp_max_profit[]">'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
      //exp_min_profit_rate, exp_max_profrate
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"exp_profrate_"+ts, addClass: "form-group"})
      );
          $("#exp_profrate_"+ts).append(
            $("<th></th>")
          );
          $("#exp_profrate_"+ts).append(
            $("<td></td>")
          );
              $("#exp_profrate_"+ts+">th").prepend(
                '<label for="exp_profrate" class="col-lg-12 control-label">見込粗利率</label>'
              );
              $("#exp_profrate_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#exp_profrate_"+ts+">td>div").prepend(
                '<input id="exp_min_profit_rate_'+ts+'" type="text" class="form-control price exp_min_profit_rate" name="exp_min_profit_rate[]">'
              );
              $("#exp_profrate_"+ts+">td").append(
                '<span class="yen">％</span>'
              );
              $("#exp_profrate_"+ts+">td").append(
                '<div class="price wave">〜</div>'
              );
              $("#exp_profrate_"+ts+">td").append(
                $("<div></div>", {addClass: "col-lg-2 tr_price max_price"})
              );
              $("#exp_profrate_"+ts+">td>div.max_price").prepend(
                '<input id="exp_max_profrate_'+ts+'" type="text" class="form-control price exp_max_profrate" name="exp_max_profrate[]">'
              );
              $("#exp_profrate_"+ts+">td").append(
                '<span class="yen">％</span>'
              );
      //buy_price
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"dom_buy_price_"+ts, addClass: "form-group"})
      );
          $("#dom_buy_price_"+ts).append(
            $("<th></th>")
          );
          $("#dom_buy_price_"+ts).append(
            $("<td></td>")
          );
              $("#dom_buy_price_"+ts+">th").prepend(
                '<label for="buy_price" class="col-lg-12 control-label">買取額</label>'
              );
              $("#dom_buy_price_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#dom_buy_price_"+ts+">td>div").prepend(
                '<input id="buy_price_'+ts+'" type="text" class="form-control price buy_price" name="buy_price[]">'
              );
              $("#dom_buy_price_"+ts+">td").append(
                '<span class="yen">円</span>'
              );
      //sell_price
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"dom_sell_price_"+ts, addClass: "form-group"})
      );
          $("#dom_sell_price_"+ts).append(
            $("<th></th>")
          );
          $("#dom_sell_price_"+ts).append(
            $("<td></td>")
          );
              $("#dom_sell_price_"+ts+">th").prepend(
                '<label for="sell_price" class="col-lg-12 control-label">販売額</label>'
              );
              $("#dom_sell_price_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#dom_sell_price_"+ts+">td>div").prepend(
                '<input id="sell_price_'+ts+'" type="text" class="form-control price sell_price" name="sell_price[]">'
              );
              $("#dom_sell_price_"+ts+">td").append(
                '<span class="yen">円</span>'
              );
      //profit
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"dom_profit_"+ts, addClass: "form-group"})
      );
          $("#dom_profit_"+ts).append(
            $("<th></th>")
          );
          $("#dom_profit_"+ts).append(
            $("<td></td>")
          );
              $("#dom_profit_"+ts+">th").prepend(
                '<label for="profit" class="col-lg-12 control-label">粗利額</label>'
              );
              $("#dom_profit_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#dom_profit_"+ts+">td>div").prepend(
                '<input id="profit_'+ts+'" type="text" class="form-control price profit" name="profit[]">'
              );
              $("#dom_profit_"+ts+">td").append(
                '<span class="yen">円</span>'
              );
      //profit_rate
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"dom_profit_rate_"+ts, addClass: "form-group"})
      );
          $("#dom_profit_rate_"+ts).append(
            $("<th></th>")
          );
          $("#dom_profit_rate_"+ts).append(
            $("<td></td>")
          );
              $("#dom_profit_rate_"+ts+">th").prepend(
                '<label for="profit" class="col-lg-12 control-label">粗利率</label>'
              );
              $("#dom_profit_rate_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#dom_profit_rate_"+ts+">td>div").prepend(
                '<input id="profit_rate_'+ts+'" type="text" class="form-control price profit_rate" name="profit_rate[]">'
              );
              $("#dom_profit_rate_"+ts+">td").append(
                '<span class="yen">％</span>'
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

  //新規登録(register)ページで削除ボタンがクリックされたた対象のタブを削除する処理
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

  //編集(edit)ページで削除ボタンがクリックされたた対象のタブを削除する処理
  $('body').on('click', '.delete_btn_edit', deleteTabEdit);
  function deleteTabEdit(){
    var deleteId = $(this).attr('id');
    var splitTs  = deleteId.split("delete_");
    $("#deleteItemId").val(splitTs[1]);
    $("#deleteTabForm").submit(); //action('ClientsController@destroy')がサブミットされる
  }

  //編集(edit)ページで返品ボタンがクリックされたた対象のタブのカラーを変える処理
  $('body').on('click', '.return_btn_edit', returnTabEdit);
  function returnTabEdit(){
    var returnId = $(this).attr('id');
    var splitTs  = returnId.split("return_");
    $("#return_item_"+splitTs[1]).val(splitTs[1]);
    $("#return_reason_"+splitTs[1]).css({
      'display' : '',
      'background-color' : '#cbb956'
    });
  }

  //item price
  //金額の入力項目において、コンマを付けたり外したりする処理
  //コンマをつける処理
  $('body').on('focusout', '.price', addComma);
  function addComma(){
    var pVal     = $(this).val();
    var commaVal = separate(pVal);
    $(this).val(commaVal);
  }
  function separate(num){
    num = String(num);
    var len = num.length;
    if(len > 3){
      return separate(num.substring(0, len-3))+','+num.substring(len-3);
    }
    else{
      return num;
    }
  }
  //コンマを外す処理
  $('body').on('focusin', '.price', removeComma);
  function removeComma(){
    var pVal = $(this).val();
    if(pVal){
      var commaVal = merge(pVal);
      $(this).val(commaVal);
    }
  }
  function merge(str){
    return str.replace(/,/g, '');
  }


  //粗利額と粗利率を自動入力する処理
  $('body').on('focusout', '.estimate_price', chkEstMinPrc);       //見積提示額がfocusoutされたら
  $('body').on('focusout', '.expsell_min_price', chkExpMinPrc);    //見込販売額がfocusoutされたら

  function chkEstMinPrc(){
    var estPrcId = $(this).attr('id');  //id取得しDOMによって生成されたものかを判断
    if(estPrcId=="estimate_price"){
      //DOMではないitem
      var id   = '';
      var estP = merge($("#estimate_price").val()); //見積提示額
      var expSellMinPrc = merge($("#expsell_min_price").val()); //見込販売額(最低)
    }
    else{
      //DOMのitem
      var id = estPrcId.split("price_");
      var estP = merge($("#estimate_price_"+id[1]).val());
      var expSellMinPrc = merge($("#expsell_min_price_"+id[1]).val());
    }
    //見積提示額と見込販売額がともに入力されていたら
    if(expSellMinPrc && estP){
      calMinProfit(expSellMinPrc, estP, id);
    }
  }

  function chkExpMinPrc(){
    var expSellMinPrcId = $(this).attr('id');
    if(expSellMinPrcId=="expsell_min_price"){
      //DOMではないitem
      var id   = '';
      var estP = merge($("#estimate_price").val());
      var expSellMinPrc = merge($("#expsell_min_price").val());
    }
    else{
      //DOMのitem
      var id = expSellMinPrcId.split("price_");
      var estP = merge($("#estimate_price_"+id[1]).val());
      var expSellMinPrc = merge($("#expsell_min_price_"+id[1]).val());
    }
    if(expSellMinPrc && estP){
      calMinProfit(expSellMinPrc, estP, id);
    }
  }

  //最低見込粗利額と粗利率を自動計算し、入力する処理
  function calMinProfit(expSellMinPrc, estP, id){
    var expMinPro   = Number(expSellMinPrc)-Number(estP);
    var expMinPrate = Math.round((Number(expMinPro)/Number(expSellMinPrc))*100);
    if(id[1]){
      $("#exp_min_profit_"+id[1]).val(separate(expMinPro));
      $("#exp_min_profit_rate_"+id[1]).val(expMinPrate);
    }
    else{
      $("#exp_min_profit").val(separate(expMinPro));
      $("#exp_min_profit_rate").val(expMinPrate);
    }
  }


  //粗利額と粗利率を自動入力する処理
  $('body').on('focusout', '.estimate_price', chkEstMaxPrc);       //見積提示額がfocusoutされたら
  $('body').on('focusout', '.expsell_max_price', chkExpMaxPrc);    //見込販売額がfocusoutされたら

  function chkEstMaxPrc(){
    var estPrcId = $(this).attr('id');  //id取得しDOMによって生成されたものかを判断
    if(estPrcId=="estimate_price"){
      //DOMではないitem
      var id   = '';
      var estP = merge($("#estimate_price").val()); //見積提示額
      var expSellMaxPrc = merge($("#expsell_max_price").val()); //見込販売額(最高)
    }
    else{
      //DOMのitem
      var id = estPrcId.split("price_");
      var estP = merge($("#estimate_price_"+id[1]).val());
      var expSellMaxPrc = merge($("#expsell_max_price_"+id[1]).val());
    }
    //見積提示額と見込販売額がともに入力されていたら
    if(expSellMaxPrc && estP){
      calMaxProfit(expSellMaxPrc, estP, id);
    }
  }

  function chkExpMaxPrc(){
    var expSellMaxPrcId = $(this).attr('id');
    if(expSellMaxPrcId=="expsell_max_price"){
      //DOMではないitem
      var id   = '';
      var estP = merge($("#estimate_price").val());
      var expSellMaxPrc = merge($("#expsell_max_price").val());
    }
    else{
      //DOMのitem
      var id = expSellMaxPrcId.split("price_");
      var estP = merge($("#estimate_price_"+id[1]).val());
      var expSellMaxPrc = merge($("#expsell_max_price_"+id[1]).val());
    }
    if(expSellMaxPrc && estP){
      calMaxProfit(expSellMaxPrc, estP, id);
    }
  }

  //最低見込粗利額と粗利率を自動計算し、入力する処理
  function calMaxProfit(expSellMaxPrc, estP, id){
    var expMaxPro   = Number(expSellMaxPrc)-Number(estP);
    var expMaxPrate = Math.round((Number(expMaxPro)/Number(expSellMaxPrc))*100);
    if(id[1]){
      $("#exp_max_profit_"+id[1]).val(separate(expMaxPro));
      $("#exp_max_profrate_"+id[1]).val(expMaxPrate);
    }
    else{
      $("#exp_max_profit").val(separate(expMaxPro));
      $("#exp_max_profrate").val(expMaxPrate);
    }
  }

  //粗利額と粗利率を自動入力する処理
  $('body').on('focusout', '.buy_price', chkBuyPrc);     //見積提示額がfocusoutされたら
  $('body').on('focusout', '.sell_price', chkSellPrc);    //見込販売額がfocusoutされたら

  function chkBuyPrc(){
    var buyPrcId = $(this).attr('id');  //id取得しDOMによって生成されたものかを判断
    if(buyPrcId=="buy_price"){
      //DOMではないitem
      var id   = '';
      var buyPrc = merge($("#buy_price").val()); //買取額
      var sellPrc = merge($("#sell_price").val()); //販売額
    }
    else{
      //DOMのitem
      var id = buyPrcId.split("price_");
      var buyPrc = merge($("#buy_price_"+id[1]).val());
      var sellPrc = merge($("#sell_price_"+id[1]).val());
    }
    //見積提示額と見込販売額がともに入力されていたら
    if(buyPrc && sellPrc){
      calProfit(buyPrc, sellPrc, id);
    }
  }

  function chkSellPrc(){
    var sellPrcId = $(this).attr('id');
    if(sellPrcId=="sell_price"){
      //DOMではないitem
      var id   = '';
      var buyPrc = merge($("#buy_price").val());
      var sellPrc = merge($("#sell_price").val());
    }
    else{
      //DOMのitem
      var id = sellPrcId.split("price_");
      var buyPrc = merge($("#buy_price_"+id[1]).val());
      var sellPrc = merge($("#sell_price_"+id[1]).val());
    }
    if(buyPrc && sellPrc){
      calProfit(buyPrc, sellPrc, id);
    }
  }

  //最低見込粗利額と粗利率を自動計算し、入力する処理
  function calProfit(buyPrc, sellPrc, id){
    var profit   = Number(sellPrc)-Number(buyPrc);
    var profitRate = Math.round((Number(profit)/Number(sellPrc))*100);
    if(id[1]){
      $("#profit_"+id[1]).val(separate(profit));
      $("#profit_rate_"+id[1]).val(profitRate);
    }
    else{
      $("#profit").val(separate(profit));
      $("#profit_rate").val(profitRate);
    }
  }

  //粗利額と粗利率を自動入力する処理
  // $('body').on('focusout', '.estimate_price', chkCalMaxProfit);       //focusoutをトリガーに設置
  // $('body').on('focusout', '.expsell_max_price', chkCalMaxProfit);    //
  // //見積額と最低見込販売額が入力されているかのチェック
  // function chkCalMaxProfit(){
  //   var expSellMaxPrc = merge($(".expsell_max_price").val());
  //   var expSellMaxPrcId = $(".expsell_max_price").attr('id');
  //   var id = expSellMaxPrcId.split("price");
  //   //新規登録か編集画面からの登録かをidの有無で判断
  //   var estP = id[1] ? merge($("#estimate_price_"+id[1]).val()): merge($("#estimate_price").val());
  //   //入力されていたら、最低見込粗利額と粗利率を自動計算し、入力する処理を発動
  //   if(expSellMaxPrc && estP){
  //     calMaxProfit(expSellMaxPrc, estP, id);
  //   }
  // }
  // //最低見込粗利額と粗利率を自動計算し、入力する処理
  // function calMaxProfit(expSellMaxPrc, estP, id){
  //   var expMaxPro   = Number(expSellMaxPrc)-Number(estP);
  //   var expMaxPrate = Math.round((Number(expMaxPro)/Number(expSellMaxPrc))*100);
  //   if(id[1]){
  //     $("#exp_max_profit_"+id[1]).val(separate(expMaxPro));
  //     $("#exp_max_profrate_"+id[1]).val(expMaxPrate);
  //   }
  //   else{
  //     $("#exp_max_profit").val(separate(expMaxPro));
  //     $("#exp_max_profrate").val(expMaxPrate);
  //   }
  // }
  //
  // //粗利額と粗利率を自動入力する処理
  // $('body').on('focusout', '.buy_price', chkCalProfit);       //focusoutをトリガーに設置
  // $('body').on('focusout', '.sell_price', chkCalProfit);    //
  // //見積額と最低見込販売額が入力されているかのチェック
  // function chkCalProfit(){
  //   var sellPrc = merge($(".sell_price").val());
  //   var sellPrcId = $(".sell_price").attr('id');
  //   var id = sellPrcId.split("price");
  //   //新規登録か編集画面からの登録かをidの有無で判断
  //   var buyP = id[1] ? merge($("#buy_price"+id[1]).val()): merge($("#buy_price").val());
  //   //入力されていたら、最低見込粗利額と粗利率を自動計算し、入力する処理を発動
  //   if(sellPrc && buyP){
  //     calProfit(sellPrc, buyP, id);
  //   }
  // }
  // //最低見込粗利額と粗利率を自動計算し、入力する処理
  // function calProfit(sellPrc, buyP, id){
  //   var profit   = Number(sellPrc)-Number(buyP);
  //   var prorate = Math.round((Number(profit)/Number(sellPrc))*100);
  //   if(id[1]){
  //     $("#profit_"+id[1]).val(separate(profit));
  //     $("#profit_rate"+id[1]).val(prorate);
  //   }
  //   else{
  //     $("#profit").val(separate(profit));
  //     $("#profit_rate").val(prorate);
  //   }
  // }



  // @TODO カテゴリーが変更された場合の処理
  //各カテゴリー毎の確認項目を特記事項の下に表示させる
  // $('body').on('change', '.select_cat', function(){
  //   var selectId = $(this).attr('id');
  //   alert(selectId);
  // });

});
