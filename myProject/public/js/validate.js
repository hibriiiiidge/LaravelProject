$(function(){
  $("body").on("click", "#new_rgst_btn", chkVali);

  function chkVali(){
    var errors = [];
    var attr = $("input[name='attribute']:checked").val();
    if(attr==null){
      errors.push("顧客属性を選択してください。");
    }

    var slct = $("#base").val();
    if(slct==""){
      errors.push("担当拠点を選択してください。");
    }

    var kana = $("#kana").val();
    console.log(kana);
    if(kana==""){
      errors.push("カナを入力してください。");
    }

    var name = $("#name").val();
    if(name==""){
      errors.push("名前を入力してください。");
    }

    if(errors.length>0){
      var error = "";
      for (var i = 0; i < errors.length; i++) {
        error += errors[i]+"\n";
      }
      alert(error);
      return false;
    }
  }
});
