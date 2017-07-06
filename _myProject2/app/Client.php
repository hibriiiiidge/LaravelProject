<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public const ZEROCNT = 3; //初期値として埋める0の数 顧客ID->7桁の0埋め ex. '0000001', '0002034'

    protected $fillable = [
      'id', 'attribute', 'base', 'name', 'kana', 'gender', 'job', 'birth', 'tel',
      'mail', 'postal_code', 'prefecture', 'address', 'memo', 'status', 'rgster', 'updter',
      'fullname','first_name','first_name_kana','fax', 'fullkana'
    ];

    public $incrementing = false;

    //client->request_details
    public function request_details(){
      return $this->hasMany('App\RequestDetail');
    }

    /**
     * ClientのIDを生成する処理
     * @param  int 桁埋めする"0"の個数
     * @return str "000000"
     */
    function zeroNum(int $n){
      $zeroAry = array();
      for ($i=0; $i < $n ; $i++) {
        array_push($zeroAry, '0');
      }
      $zeroStr = implode("", $zeroAry);
      return $zeroStr;
    }

    /**
     * 姓名を結合する処理
     * @param string name ex. "Yasunori Takahashi　"
     * @return string name ex. "YasunoriTakahashi"
     */
    function chgFullName($name){
      return str_replace(array(' ', '　'), '', $name);
    }

    /**
     * 姓と名を別々の配列に分離する処理
     * @param string name
     * @return array [last_name, first_name]
     */
    function split_name($name){
      $nameAry = [];
      $name = str_replace('　', ' ', $name);
      $name = trim($name);
      $name = preg_replace('/\s+/', ' ', $name);
      $nameAry = explode(' ', $name);
      return $nameAry;
    }

}
