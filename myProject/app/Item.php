<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
      'id', 'request_id', 'category', 'status', 'rgster', 'updter',
      'name', 'outside_condition', 'inside_condition', 'cooling_off_flg',
      'memo', 'no_underscore_id ', 'count','return_reason', 'estimate_price',
      'expsell_min_price', 'expsell_max_price', 'exp_min_profit', 'exp_max_profit',
      'exp_min_profit_rate', 'exp_max_profit_rate', 'buy_price', 'sell_price',
      'profit', 'profit_rate', 'number', 'maker', 'item_no', 'item_group_no',
      'total_estimate_price', 'total_expsell_min_price', 'total_expsell_max_price',
      'total_exp_min_profit', 'total_exp_max_profit', 'total_buy_price',
      'start_price', 'expsell_price'
    ];

    protected $touches = array('request_detail');

    //item->request_detail
    public function request_detail(){
      return $this->belongsTo('App\RequestDetail', 'request_id', 'request_id');
    }

    //item->item_progresses
    public function item_progresses(){
      return $this->hasMany('App\ItemProgress', 'id', 'item_id');
    }
}
