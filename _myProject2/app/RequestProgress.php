<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestProgress extends Model
{
    protected $fillable = [
      'request_id', 'flow_no', 'progress_status', 'progress_memo', 'status', 'rgster', 'updter'
    ];

    protected $touches = array('request_detail');

    //request_progress->request_detail
    public function request_detail(){
      return $this->belongsTo('App\RequestDetail', 'request_id', 'request_id');
    }
}
