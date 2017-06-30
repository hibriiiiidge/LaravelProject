$(function(){
  //カテゴリーが選択されら
  $('body').on('change', '.select_cat', chgMaker);
  $('body').on('change', '.select_cat', addChkList);
  //カテゴリーの属するメーカーセレクトを自動生成
  function chgMaker(){
    var categoryNo   = $(this).attr('id');
    var splitNo      = categoryNo.split("_");
    var categoryId  = $(this).val();
    var url = "http://homestead.app/api/item_makers/"+categoryId;

    $.ajax({
      url: url,
      type: "GET",
      dataType: "json"
    })
    .then(
      function(res){
        makerOptions = '';
        for (var i = 0; i < res.length; i++) {
          makerOptions += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
        }
        makerOptions += '<option value="999">その他</option>';
        if(splitNo[1]){
          $('#maker_'+splitNo[1]).html(makerOptions);
        }
        else{
          $('#maker').html(makerOptions);
        }
      },
      function(res){
        alert("メーカーの自動取得に失敗しました。手動でご入力いただき、その旨を技術担当までご報告ください。");
      }
    );
  }
  //カテゴリーごとの確認項目を特記事項の下に表示&管理者メモに追加
  function addChkList(){
    var categoryNo   = $(this).attr('id');
    var splitNo      = categoryNo.split("_");
    var categoryId  = $(this).val();
    var itemMemo = splitNo[1] ? $('#item_memo_'+splitNo[1]).val() :  $('#item_memo').val();
    var summaryMemoSub = $('#summary_memo_sub').val();
    var url = "http://homestead.app/api/item_categories/"+categoryId;
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json"
    })
    .then(
      function(res){
        itemMemo += ("\n" +res.check_list);
        summaryMemoSub += ("\n" +res.check_list);
        if(splitNo[1]){
          $('#item_memo_'+splitNo[1]).val(itemMemo);
        }
        else{
          $('#item_memo').val(itemMemo);
        }
        $('#summary_memo_sub').val(summaryMemoSub);
      },
      function(res){
        alert("カテゴリー毎の確認事項を取得出来ませんでした。その旨を技術担当までご報告ください。");
      }
    );
  }


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
      $.ajax({
        url: "http://homestead.app/api/item_categories",
        type: "GET",
        dataType: "json"
      })
      .then(
        function(res){
          cateOptions = '';
          for (var i = 0; i < res.length; i++) {
            if(res[i].status!=='X'){
              cateOptions += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
            }
          }
        },
        function(res){
          alert("カテゴリーが取得できませんでした。技術担当に確認してください。");
        })
      .done(function (){
        addItem(cateOptions);
      });
    }
  }
  //次の商品入力フォームを生成する処理
  function addItem(cateOptions){
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
                  '<option value="">未選択</option>'+cateOptions);
        //maker
        $("#item_request_table_"+ts+">tbody").append(
          $("<tr></tr>", {Id:"item_maker_"+ts, addClass: "form-group"})
        );
            $("#item_maker_"+ts).append(
              $("<th></th>")
            );
            $("#item_maker_"+ts).append(
              $("<td></td>")
            );
                $("#item_maker_"+ts+">th").prepend(
                  '<label for="maker" class="col-lg-12 control-label">メーカー</label>'
                );
                $("#item_maker_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#item_maker_"+ts+">td>div").prepend(
                  $("<select></select>", {Id:"maker_"+ts, addClass: "form-control select_maker", name:"maker[]"})
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
          $("<tr></tr>", {Id:"dom_item_memo_"+ts, addClass: "form-group"})
        );
            $("#dom_item_memo_"+ts).append(
              $("<th></th>")
            );
            $("#dom_item_memo_"+ts).append(
              $("<td></td>")
            );
                $("#dom_item_memo_"+ts+">th").prepend(
                  '<label for="item_memo" class="col-lg-12 control-label">特記事項</label>'
                );
                $("#dom_item_memo_"+ts+">td").prepend(
                  $("<div></div>", {addClass: "col-lg-12"})
                );
                $("#dom_item_memo_"+ts+">td>div").prepend(
                  '<textarea name="item_memo['+ts+']" rows="8" cols="80" id="item_memo_'+ts+'"></textarea>'
                );
      //item_num
      $("#item_request_table_"+ts+">tbody").append(
        $("<tr></tr>", {Id:"dom_item_num_"+ts, addClass: "form-group"})
      );
          $("#dom_item_num_"+ts).append(
            $("<th></th>")
          );
          $("#dom_item_num_"+ts).append(
            $("<td></td>")
          );
              $("#dom_item_num_"+ts+">th").prepend(
                '<label for="item_num" class="col-lg-12 control-label">商品数</label>'
              );
              $("#dom_item_num_"+ts+">td").prepend(
                $("<div></div>", {addClass: "col-lg-2 tr_price"})
              );
              $("#dom_item_num_"+ts+">td>div").prepend(
                '<input id="item_num_'+ts+'" type="text" class="form-control item_num" name="item_num[]" value="1">'
              );
              $("#dom_item_num_"+ts+">td").append(
                '<span class="yen">個</span>'
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
                $("#dom_estimate_price_"+ts+">td").prepend(
                  '<div class="by_title no_display_'+ts+'" style="display: none;">'
                );
                $("#dom_estimate_price_"+ts+">td>div.by_title").prepend(
                  '<div class="by_item">(一商品あたり)</div><div class="by_total_item">(合計)</div>'
                );
                $("#dom_estimate_price_"+ts+">td>div.tr_price").prepend(
                  '<input id="estimate_price_'+ts+'" type="text" class="form-control price estimate_price" name="estimate_price[]">'
                );
                $("#dom_estimate_price_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
                $("#dom_estimate_price_"+ts+">td").append(
                  '<div class="col-lg-7 tr_price total_price ttl_est_price no_display_'+ts+'" style="display: none;">'
                );
                $("#dom_estimate_price_"+ts+">td>div.total_price").prepend(
                  '<span id="total_est_price_'+ts+'">--</span>円'
                );
                $("#dom_estimate_price_"+ts+">td>div.total_price").prepend(
                  '<input type="hidden" id="hid_total_est_price_'+ts+'" name="total_est_price[]">'
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
                $("#expsell_price_"+ts+">td").prepend(
                  '<div class="by_title no_display_'+ts+'" style="display: none;">'
                );
                $("#expsell_price_"+ts+">td>div.by_title").prepend(
                  '<div class="by_item">(一商品あたり)</div><div class="by_total_item">(合計)</div>'
                );
                $("#expsell_price_"+ts+">td>div.tr_price").prepend(
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

                $("#expsell_price_"+ts+">td").append(
                  '<div class="col-lg-4 tr_price total_price no_display_'+ts+'" style="display:none;">'
                );
                $("#expsell_price_"+ts+">td>div.total_price").append(
                  '<span id="total_expsell_min_price_'+ts+'">--</span>円'
                );
                $("#expsell_price_"+ts+">td>div.total_price").append(
                  '<input type="hidden" id="hid_total_expsell_min_price_'+ts+'" name="total_expsell_min_price[]">'
                );
                $("#expsell_price_"+ts+">td>div.total_price").append(
                  '<span>~</span>'
                );
                $("#expsell_price_"+ts+">td>div.total_price").append(
                  '<span id="total_expsell_max_price_'+ts+'">--</span>円'
                );
                $("#expsell_price_"+ts+">td>div.total_price").append(
                  '<input type="hidden" id="hid_total_expsell_max_price_'+ts+'" name="total_expsell_max_price[]">'
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
                  $("<div></div>", {addClass: "col-lg-2 tr_price text_price"})
                );
                $("#exp_profit_"+ts+">td").prepend(
                  '<div class="by_title no_display_'+ts+'" style="display: none;">'
                );
                $("#exp_profit_"+ts+">td>div.by_title").prepend(
                  '<div class="by_item">(一商品あたり)</div><div class="by_total_item">(合計)</div>'
                );
                $("#exp_profit_"+ts+">td>div.tr_price").prepend(
                  '<span id="exp_min_profit_'+ts+'" class="span_text_price"></span>' +
                  '<input type="hidden" id="hid_exp_min_profit_'+ts+'" name="exp_min_profit[]">'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<div class="price wave">〜</div>'
                );
                $("#exp_profit_"+ts+">td").append(
                  $("<div></div>", {addClass: "col-lg-2 tr_price max_price text_price"})
                );
                $("#exp_profit_"+ts+">td>div.max_price").prepend(
                  '<span id="exp_max_profit_'+ts+'" class="span_text_price"></span>' +
                  '<input type="hidden" id="hid_exp_max_profit_'+ts+'" name="exp_max_profit[]">'
                );
                $("#exp_profit_"+ts+">td").append(
                  '<span class="yen">円</span>'
                );

                $("#exp_profit_"+ts+">td").append(
                  '<div class="col-lg-4 tr_price total_price no_display_'+ts+'" style="display:none;">'
                );
                $("#exp_profit_"+ts+">td>div.total_price").append(
                  '<span id="total_exp_min_profit_'+ts+'">--</span>円'
                );
                $("#exp_profit_"+ts+">td>div.total_price").append(
                  '<input type="hidden" id="hid_total_exp_min_profit_'+ts+'" name="total_exp_min_profit[]">'
                );
                $("#exp_profit_"+ts+">td>div.total_price").append(
                  '<span>~</span>'
                );
                $("#exp_profit_"+ts+">td>div.total_price").append(
                  '<span id="total_exp_max_profit_'+ts+'">--</span>円'
                );
                $("#exp_profit_"+ts+">td>div.total_price").append(
                  '<input type="hidden" id="hid_total_exp_max_profit_'+ts+'" name="total_exp_max_profit[]">'
                );
      //exp_min_profit_rate, exp_max_profit_rate
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
                $("<div></div>", {addClass: "col-lg-2 tr_price text_price"})
              );
              $("#exp_profrate_"+ts+">td>div").prepend(
                '<span id="exp_min_profit_rate_'+ts+'" class="span_text_price"></span>'+
                '<input type="hidden" id="hid_exp_min_profit_rate_'+ts+'" name="exp_min_profit_rate[]">'
              );
              $("#exp_profrate_"+ts+">td").append(
                '<span class="yen">％</span>'
              );
              $("#exp_profrate_"+ts+">td").append(
                '<div class="price wave">〜</div>'
              );
              $("#exp_profrate_"+ts+">td").append(
                $("<div></div>", {addClass: "col-lg-2 tr_price max_price text_price"})
              );
              $("#exp_profrate_"+ts+">td>div.max_price").prepend(
                '<span id="exp_max_profit_rate_'+ts+'" class="span_text_price"></span>'+
                '<input type="hidden" id="hid_exp_max_profit_rate_'+ts+'" name="exp_max_profit_rate[]">'
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
              $("#dom_buy_price_"+ts+">td").prepend(
                '<div class="by_title no_display_'+ts+'" style="display: none;">'
              );
              $("#dom_buy_price_"+ts+">td>div.by_title").prepend(
                '<div class="by_item">(一商品あたり)</div><div class="by_total_item">(合計)</div>'
              );
              $("#dom_buy_price_"+ts+">td>div.tr_price").prepend(
                '<input id="buy_price_'+ts+'" type="text" class="form-control price buy_price" name="buy_price[]">'
              );
              $("#dom_buy_price_"+ts+">td").append(
                '<span class="yen">円</span>'
              );
              $("#dom_buy_price_"+ts+">td").append(
                '<div class="col-lg-3 col-lg-offset-4 tr_price total_price no_display_'+ts+'" style="display:none;">'
              );
              $("#dom_buy_price_"+ts+">td>div.total_price").prepend(
                '<input id="total_buy_price_'+ts+'" type="text" class="form-control price total_buy_price" name="total_buy_price[]">'
              );
              $("#dom_buy_price_"+ts+">td").append(
                '<span class="yen">円</span>'
              );
      // 実際の販売額・粗利額・粗利率は商品の詳細ページにて入力する仕様に実装予定 2017.06.30 takahashi
      //sell_price
      // $("#item_request_table_"+ts+">tbody").append(
      //   $("<tr></tr>", {Id:"dom_sell_price_"+ts, addClass: "form-group"})
      // );
      //     $("#dom_sell_price_"+ts).append(
      //       $("<th></th>")
      //     );
      //     $("#dom_sell_price_"+ts).append(
      //       $("<td></td>")
      //     );
      //         $("#dom_sell_price_"+ts+">th").prepend(
      //           '<label for="sell_price" class="col-lg-12 control-label">販売額</label>'
      //         );
      //         $("#dom_sell_price_"+ts+">td").prepend(
      //           $("<div></div>", {addClass: "col-lg-2 tr_price"})
      //         );
      //         $("#dom_sell_price_"+ts+">td>div").prepend(
      //           '<input id="sell_price_'+ts+'" type="text" class="form-control price sell_price" name="sell_price[]">'
      //         );
      //         $("#dom_sell_price_"+ts+">td").append(
      //           '<span class="yen">円</span>'
      //         );
      // //profit
      // $("#item_request_table_"+ts+">tbody").append(
      //   $("<tr></tr>", {Id:"dom_profit_"+ts, addClass: "form-group"})
      // );
      //     $("#dom_profit_"+ts).append(
      //       $("<th></th>")
      //     );
      //     $("#dom_profit_"+ts).append(
      //       $("<td></td>")
      //     );
      //         $("#dom_profit_"+ts+">th").prepend(
      //           '<label for="profit" class="col-lg-12 control-label">粗利額</label>'
      //         );
      //         $("#dom_profit_"+ts+">td").prepend(
      //           $("<div></div>", {addClass: "col-lg-2 tr_price text_price"})
      //         );
      //         $("#dom_profit_"+ts+">td>div").prepend(
      //           '<span id="profit_'+ts+'" class="span_text_price"></span>'+
      //           '<input type="hidden" id="hid_profit_'+ts+'" name="profit[]">'
      //         );
      //         $("#dom_profit_"+ts+">td").append(
      //           '<span class="yen">円</span>'
      //         );
      // //profit_rate
      // $("#item_request_table_"+ts+">tbody").append(
      //   $("<tr></tr>", {Id:"dom_profit_rate_"+ts, addClass: "form-group"})
      // );
      //     $("#dom_profit_rate_"+ts).append(
      //       $("<th></th>")
      //     );
      //     $("#dom_profit_rate_"+ts).append(
      //       $("<td></td>")
      //     );
      //         $("#dom_profit_rate_"+ts+">th").prepend(
      //           '<label for="profit" class="col-lg-12 control-label">粗利率</label>'
      //         );
      //         $("#dom_profit_rate_"+ts+">td").prepend(
      //           $("<div></div>", {addClass: "col-lg-2 tr_price text_price"})
      //         );
      //         $("#dom_profit_rate_"+ts+">td>div").prepend(
      //           '<span id="profit_rate_'+ts+'" class="span_text_price"></span>'+
      //           '<input type="hidden" id="hid_profit_rate_'+ts+'" name="profit_rate[]">'
      //         );
      //         $("#dom_profit_rate_"+ts+">td").append(
      //           '<span class="yen">％</span>'
      //         );


    $("#item_tbl_res_"+ts).prepend(
      $("<div></div>", {Id:"item_hidden_"+ts, addClass: "item_hidden"})
    );
        $("#item_hidden_"+ts).prepend(
          '<input type="hidden" name="item_group[]" value="'+ts+'">'
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
    if(confirm('商品情報を削除しますか？')){
      var deleteId = $(this).attr('id');
      var splitTs  = deleteId.split("delete_");
      $("#deleteItemGroup").val(splitTs[1]);
      $("#deleteTabForm").submit(); //action('ClientsController@destroy')がサブミットされる
    }
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
      $("#exp_min_profit_"+id[1]).text(separate(expMinPro));
      $("#hid_exp_min_profit_"+id[1]).val(separate(expMinPro));
      $("#exp_min_profit_rate_"+id[1]).text(expMinPrate);
      $("#hid_exp_min_profit_rate_"+id[1]).val(expMinPrate);
    }
    else{
      $("#exp_min_profit").text(separate(expMinPro));
      $("#hid_exp_min_profit").val(separate(expMinPro));
      $("#exp_min_profit_rate").text(expMinPrate);
      $("#hid_exp_min_profit_rate").val(expMinPrate);
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
      $("#exp_max_profit_"+id[1]).text(separate(expMaxPro));
      $("#hid_exp_max_profit_"+id[1]).val(separate(expMaxPro));
      $("#exp_max_profit_rate_"+id[1]).text(expMaxPrate);
      $("#hid_exp_max_profit_rate_"+id[1]).val(separate(expMaxPrate));
    }
    else{
      $("#exp_max_profit").text(separate(expMaxPro));
      $("#hid_exp_max_profit").val(separate(expMaxPro));
      $("#exp_max_profit_rate").text(expMaxPrate);
      $("#hid_exp_max_profit_rate").val(separate(expMaxPrate));
    }
  }

  //粗利額と粗利率を自動入力する処理
  //$('body').on('focusout', '.buy_price', chkBuyPrc);     //見積提示額がfocusoutされたら
  //$('body').on('focusout', '.sell_price', chkSellPrc);    //見込販売額がfocusoutされたら

  // function chkBuyPrc(){
  //   var buyPrcId = $(this).attr('id');  //id取得しDOMによって生成されたものかを判断
  //   if(buyPrcId=="buy_price"){
  //     //DOMではないitem
  //     var id   = '';
  //     var buyPrc = merge($("#buy_price").val()); //買取額
  //     var sellPrc = merge($("#sell_price").val()); //販売額
  //   }
  //   else{
  //     //DOMのitem
  //     var id = buyPrcId.split("price_");
  //     var buyPrc = merge($("#buy_price_"+id[1]).val());
  //     var sellPrc = merge($("#sell_price_"+id[1]).val());
  //   }
  //   //見積提示額と見込販売額がともに入力されていたら
  //   if(buyPrc && sellPrc){
  //     calProfit(buyPrc, sellPrc, id);
  //   }
  // }
  //
  // function chkSellPrc(){
  //   var sellPrcId = $(this).attr('id');
  //   if(sellPrcId=="sell_price"){
  //     //DOMではないitem
  //     var id   = '';
  //     var buyPrc = merge($("#buy_price").val());
  //     var sellPrc = merge($("#sell_price").val());
  //   }
  //   else{
  //     //DOMのitem
  //     var id = sellPrcId.split("price_");
  //     var buyPrc = merge($("#buy_price_"+id[1]).val());
  //     var sellPrc = merge($("#sell_price_"+id[1]).val());
  //   }
  //   if(buyPrc && sellPrc){
  //     calProfit(buyPrc, sellPrc, id);
  //   }
  // }
  //
  // //見粗利額と粗利率を自動計算し、入力する処理
  // function calProfit(buyPrc, sellPrc, id){
  //   var profit   = Number(sellPrc)-Number(buyPrc);
  //   var profitRate = Math.round((Number(profit)/Number(sellPrc))*100);
  //   if(id[1]){
  //     $("#profit_"+id[1]).text(separate(profit));
  //     $("#hid_profit_"+id[1]).val(separate(profit));
  //     $("#profit_rate_"+id[1]).text(profitRate);
  //     $("#hid_profit_rate_"+id[1]).val(profitRate);
  //   }
  //   else{
  //     $("#profit").text(separate(profit));
  //     $("#hid_profit").val(separate(profit));
  //     $("#profit_rate").text(profitRate);
  //     $("#hid_profit_rate").val(separate(profitRate));
  //   }
  // }


  $('body').on('focusout', '.item_num', chkNumEstP);
  $('body').on('focusout', '.estimate_price', chkEstPNum);

  function chkNumEstP(){
    var itemNumId = $(this).attr('id');
    var numVal = $(this).val();
    if(!numVal || numVal==0){alert("商品数を入力してください。");}
    if(itemNumId=="item_num"){
      //DOMではないitem
      var id   = '';
      var estP = merge($("#estimate_price").val());
    }
    else{
      //DOMのitem
      var id = itemNumId.split("num_");
      var estP = merge($("#estimate_price_"+id[1]).val());
    }
    if(numVal && estP){
      insertTotalEstP(numVal, estP, id);
    }
  }
  function chkEstPNum(){
    var estPrcId = $(this).attr('id');
    var estP = merge($(this).val());
    if(!estP || estP==0){alert("見積提示額を入力してください。");}
    if(estPrcId=="estimate_price"){
      //DOMではないitem
      var id   = '';
      var numVal = $("#item_num").val();
      var expSellMinP = merge($("#expsell_min_price").val());
      var expSellMaxP = merge($("#expsell_max_price").val());
    }
    else{
      //DOMのitem
      var id = estPrcId.split("price_");
      var numVal = $("#item_num_"+id[1]).val();
      var expSellMinP = merge($("#expsell_min_price_"+id[1]).val());
      var expSellMaxP = merge($("#expsell_max_price_"+id[1]).val());
    }
    if(numVal && estP){
      insertTotalEstP(numVal, estP, id);
    }
    if(numVal && estP && expSellMinP){
      insertTotalExpSellMinProfit(numVal, estP, expSellMinP, id);
    }
    if(numVal && estP && expSellMaxP){
      insertTotalExpSellMaxProfit(numVal, estP, expSellMaxP, id);
    }
  }
  function insertTotalEstP(numVal, estP, id){
    var totalEstP = separate(numVal*estP);
    if(id[1]){
      $('#total_est_price_'+id[1]).text(totalEstP);
      $('#hid_total_est_price_'+id[1]).val(totalEstP);
    }
    else {
      $('#total_est_price').text(totalEstP);
      $('#hid_total_est_price').val(totalEstP);
    }
  }
  // function insertMinProfit(numVal, estP, expSellMinP, id){
  //   var totalEstP = numVal*estP;
  //   var totalEstMinP = numVal*expSellMinP;
  //   var totalEstMinProfit = separate(totalEstMinP-totalEstP);
  //   if(id[1]){
  //     $('#total_exp_min_profit_'+id[1]).text(totalEstMinProfit);
  //     $('#hid_total_exp_min_profit_'+id[1]).val(totalEstMinProfit);
  //   }
  //   else{
  //     $('#total_exp_min_profit').text(totalEstMinProfit);
  //     $('#hid_total_exp_min_profit').val(totalEstMinProfit);
  //
  //   }
  // }
  // function insertMaxProfit(numVal, estP, expSellMaxP, id){
  //   var totalEstP = numVal*estP;
  //   var totalEstMaxP = numVal*expSellMaxP;
  //   var totalEstMaxProfit = separate(totalEstMaxP-totalEstP);
  //   if(id[1]){
  //     $('#total_exp_max_profit_'+id[1]).text(totalEstMaxProfit);
  //     $('#hid_total_exp_max_profit_'+id[1]).val(totalEstMaxProfit);
  //   }
  //   else{
  //     $('#total_exp_max_profit').text(totalEstMaxProfit);
  //     $('#hid_total_exp_max_profit').val(totalEstMaxProfit);
  //   }
  // }


  $('body').on('focusout', '.item_num', chkNumExpSellMinP);
  $('body').on('focusout', '.expsell_min_price', chkExpSellMinPNum);

  function chkNumExpSellMinP(){
    var itemNumId = $(this).attr('id');
    var numVal = $(this).val();
    if(!numVal || numVal==0){alert("商品数を入力してください。");}
    if(itemNumId=="item_num"){
      //DOMではないitem
      var id   = '';
      var expSellMinP = merge($("#expsell_min_price").val());
      var estP = merge($("#estimate_price").val());
    }
    else{
      //DOMのitem
      var id = itemNumId.split("num_");
      var expSellMinP = merge($("#expsell_min_price_"+id[1]).val());
      var estP = merge($("#estimate_price_"+id[1]).val());
    }
    if(numVal && expSellMinP){
      insertTotalExpSellMinP(numVal, expSellMinP, id);
    }
    if(numVal && expSellMinP && estP){
      insertTotalExpSellMinProfit(numVal, estP, expSellMinP, id);
    }
  }

  function chkExpSellMinPNum(){
    var expSellMinPrcId = $(this).attr('id');
    var expSellMinP = merge($(this).val());
    if(!expSellMinP || expSellMinP==0){alert("見込販売額を入力してください。");}
    if(expSellMinPrcId=="expsell_min_price"){
      //DOMではないitem
      var id   = '';
      var numVal = $("#item_num").val();
      var estP = merge($("#estimate_price").val());
    }
    else{
      //DOMのitem
      var id = expSellMinPrcId.split("price_");
      var numVal = $("#item_num_"+id[1]).val();
      var estP = merge($("#estimate_price_"+id[1]).val());
    }
    if(numVal && expSellMinP){
      insertTotalExpSellMinP(numVal, expSellMinP, id);
    }
    if(numVal && expSellMinP && estP){
      insertTotalExpSellMinProfit(numVal, estP, expSellMinP, id);
    }
  }
  function insertTotalExpSellMinP(numVal, expSellMinP, id){
    var totalExpSellMinP = separate(numVal*expSellMinP);
    if(id[1]){
      $('#total_expsell_min_price_'+id[1]).text(totalExpSellMinP);
      $('#hid_total_expsell_min_price_'+id[1]).val(totalExpSellMinP);
    }
    else {
      $('#total_expsell_min_price').text(totalExpSellMinP);
      $('#hid_total_expsell_min_price').val(totalExpSellMinP);
    }
  }

  function insertTotalExpSellMinProfit(numVal, estP, expSellMinP, id){
    var totalEstP = numVal * estP;
    var totalExpSellMinP = numVal * expSellMinP;
    var totalEstMinProfit =  separate(totalExpSellMinP - totalEstP);
    if(id[1]){
      $('#total_exp_min_profit_'+id[1]).text(totalEstMinProfit);
      $('#hid_total_exp_min_profit_'+id[1]).val(totalEstMinProfit);
    }
    else {
      $('#total_exp_min_profit').text(totalEstMinProfit);
      $('#hid_total_exp_min_profit').val(totalEstMinProfit);
    }
  }



  $('body').on('focusout', '.item_num', chkNumExpSellMaxP);
  $('body').on('focusout', '.expsell_max_price', chkExpSellMaxPNum);

  function chkNumExpSellMaxP(){
    var itemNumId = $(this).attr('id');
    var numVal = $(this).val();
    if(!numVal || numVal==0){alert("商品数を入力してください。");}
    if(itemNumId=="item_num"){
      //DOMではないitem
      var id   = '';
      var expSellMaxP = merge($("#expsell_max_price").val());
      var estP = merge($("#estimate_price").val());
    }
    else{
      //DOMのitem
      var id = itemNumId.split("num_");
      var expSellMaxP = merge($("#expsell_max_price_"+id[1]).val());
      var estP = merge($("#estimate_price_"+id[1]).val());
    }
    if(numVal && expSellMaxP){
      insertTotalExpSellMaxP(numVal, expSellMaxP, id);
    }
    if(numVal && expSellMaxP && estP){
      insertTotalExpSellMaxProfit(numVal, estP, expSellMaxP, id);
    }
  }
  function chkExpSellMaxPNum(){
    var expSellMaxPrcId = $(this).attr('id');
    var expSellMaxP = merge($(this).val());
    if(!expSellMaxP || expSellMaxP==0){alert("見込販売額を入力してください。");}
    if(expSellMaxPrcId=="expsell_max_price"){
      //DOMではないitem
      var id   = '';
      var numVal = $("#item_num").val();
      var estP = merge($("#estimate_price").val());
    }
    else{
      //DOMのitem
      var id = expSellMaxPrcId.split("price_");
      var numVal = $("#item_num_"+id[1]).val();
      var estP = merge($("#estimate_price_"+id[1]).val());
    }
    if(numVal && expSellMaxP){
      insertTotalExpSellMaxP(numVal, expSellMaxP, id);
    }
    if(numVal && expSellMaxP && estP){
      insertTotalExpSellMaxProfit(numVal, estP, expSellMaxP, id);
    }
  }
  function insertTotalExpSellMaxP(numVal, expSellMaxP, id){
    var totalExpSellMaxP = separate(numVal*expSellMaxP);
    if(id[1]){
      $('#total_expsell_max_price_'+id[1]).text(totalExpSellMaxP);
      $('#hid_total_expsell_max_price_'+id[1]).val(totalExpSellMaxP);
    }
    else {
      $('#total_expsell_max_price').text(totalExpSellMaxP);
      $('#hid_total_expsell_max_price').val(totalExpSellMaxP);
    }
  }
  function insertTotalExpSellMaxProfit(numVal, estP, expSellMaxP, id){
    var totalEstP = numVal * estP;
    var totalExpSellMaxP = numVal * expSellMaxP;
    var totalEstMaxProfit =  separate(totalExpSellMaxP - totalEstP);
    if(id[1]){
      $('#total_exp_max_profit_'+id[1]).text(totalEstMaxProfit);
      $('#hid_total_exp_max_profit_'+id[1]).val(totalEstMaxProfit);
    }
    else {
      $('#total_exp_max_profit').text(totalEstMaxProfit);
      $('#hid_total_exp_max_profit').val(totalEstMaxProfit);
    }
  }

  $('body').on('focusout', '.total_buy_price', calBuyP);
  $('body').on('focusout', '.buy_price', calTotalBuyP);

  function calBuyP(){
    var totalBuyPId = $(this).attr('id');
    var totalBuyP = merge($(this).val());
    if(totalBuyPId=="total_buy_price"){
      var numVal = $("#item_num").val();
      var buyPrc = separate(Math.round(totalBuyP/numVal));
      $('#buy_price').val(buyPrc);
    }
    else{
      var id = totalBuyPId.split("price_");
      var numVal = $("#item_num_"+id[1]).val();
      var buyPrc = separate(Math.round(totalBuyP/numVal));
      $('#buy_price_'+id[1]).val(buyPrc);
    }
  }

  function calTotalBuyP(){
    var buyPId = $(this).attr('id');
    var buyP = merge($(this).val());
    if(buyPId=="buy_price"){
      var numVal = $("#item_num").val();
      var totalBuyPrc = separate(buyP*numVal);
      $('#total_buy_price').val(totalBuyPrc);
    }
    else{
      var id = buyPId.split("price_");
      var numVal = $("#item_num_"+id[1]).val();
      var totalBuyPrc = separate(buyP*numVal);
      $('#total_buy_price_'+id[1]).val(totalBuyPrc);
    }
  }

  //非表示->表示
  $('body').on('focusout', '.item_num', cntNum);

  function cntNum(){
    var itemNumId = $(this).attr('id');
    var id = itemNumId.split("num_")
    var num = $(this).val();
    if(num>1){
      if(id[1]){
        $('.no_display_'+id[1]).css({
          'display':''
        });
      }
      else{
        $('.no_display').css({
          'display':''
        });
      }
    }

    if(num==1){
      if(id[1]){
        $('.no_display_'+id[1]).css({
          'display':'none'
        });
      }
      else{
        $('.no_display').css({
          'display':'none'
        });
      }
    }


  }

});
