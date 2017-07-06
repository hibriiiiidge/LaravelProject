$(function(){
  $('body').on('click', '.rgst_btn', chgCode);
  //金融機関コード、支店コードをhiddenに持たせる処理
  function chgCode(){
    var bkCode = $('#bank_code').text();
    $('#hd_bank_code').val(bkCode);
    var brCode = $('#branch_code').text();
    $('#hd_branch_code').val(brCode);
  }
});
