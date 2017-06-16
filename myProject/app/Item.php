<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
      'id', 'request_id', 'category', 'status', 'rgster', 'updter'
    ];

    protected $touches = array('request_detail');

    //item->request_detail
    public function request_detail(){
      return $this->belongsTo('App\RequestDetail', 'request_id', 'request_id');
    }
}
