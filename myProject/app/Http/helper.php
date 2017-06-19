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
   * table上のPriceは''ではなく'-'をリターン
   */
  function nf_TP($num){
    return $num ? number_format($num): '-';
  }
