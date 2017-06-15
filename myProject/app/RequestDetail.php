<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
  protected $fillable = [
    'request_id', 'client_id', 'urgency', 'buy_way', 'contact_way',
    'route', 'competitive_flg', 'summary_memo', 'status',
    'rgster', 'updter', 'reason'
  ];

  protected $touches = array('client');

  //request_datail->client
  public function client(){
    return $this->belongsTo('App\Client');
  }
  //request_detail->request_progresses
  public function request_progresses(){
    return $this->hasMany('App\RequestProgress', 'request_id', 'request_id');
  }
  //request_detail->items
  public function items(){
    return $this->hasMany('App\Item', 'request_id', 'request_id')->where('status', '<>', 'X')->orderBy('count', 'ASC');
  }

}
