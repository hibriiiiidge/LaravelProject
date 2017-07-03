<?php

  /**
   * 値が存在していたらnumber_formatを適応した値をリターンし、そうでなければ''を返す
   * @param $num integer
   * @return $num integer or ''
   */
  function nf($num){
    return $num ? number_format($num): '';
  }
  /**
   * table上のpriceは''ではなく'-'をリターン
   */
  function nf_TP($num){
    return $num ? number_format($num): '-';
  }
  /**
   * table上のstringeは''ではなく'-'をリターン
   */
  function chkStr($str){
    return $str ? $str: '-';
  }
  /**
   * table上のstringeは''ではなく'-'をリターン
   */
  function chkRate($str){
    if(!$str){
      return '-';
    }
    else {
      $newStr = explode('.', $str);
      return $newStr[0];
    }
  }
  /**
   * table上のdtの整形
   * @param $dt ex. 2017-06-19 19:12:28
   * @return $dt ex. 06/19 19:12
   */
  function chgDtFrmt($dt){
    return date("m/d H:i", strtotime($dt));
  }
