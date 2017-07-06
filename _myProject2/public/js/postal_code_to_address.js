$(function(){
  $('body').on('focusout', '.postal_code', getAddress);
  function getAddress(){
    //郵便番号取得
    var postalCode    = $(this).val();
    var postalCodeId  = $(this).attr('id');
    var judgePage     = postalCodeId.indexOf('b_');
    if(judgePage!=-1){
      //新規拠点登録のページ
      var selectId = "#b_prefecture";
      var addrssId = "#b_address";
    }
    else{
      //顧客情報登録ページ
      var selectId = "#prefecture";
      var addrssId = "#address";
    }

    $.ajax({
      url: "http://api.zipaddress.net/",
      type: "GET",
      dataType: "json",
      data: {
        zipcode: postalCode,
        lang: 'ja'
      }
    })
    .then(
      function(res){
        //selectのoption要素を全て取得し、該当する都道府県のvalを返す
        var opts = $(selectId).children();
        for (var i = 0; i < opts.length; i++) {
          if(opts.eq(i).text() == res.data.pref){
            var optsVal = opts.eq(i).val();
          }
        }
        $("select"+selectId).val(optsVal);             //select選択
        $(addrssId).val(res.data.address);  //住所に値入力
      },
      function(res){
        alert("住所の取得に失敗しました。申し訳ございませんが、手動で入力してください。");
      });
  }
});
