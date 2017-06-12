<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
      'id', 'request_id', 'category', 'status', 'rgster', 'updter'
    ];

    //item->request_datail
    public function request_datail(){
      return $this->belongsTo('App\RequestDetail', 'request_id', 'request_id');
    }
}
