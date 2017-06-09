<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestProgress extends Model
{
    protected $fillable = [
      'request_id', 'flow_no', 'progress_status', 'progress_memo', 'status', 'rgster', 'updter'
    ];

    //request_progress->request_datail
    public function request_detail(){
      return $this->belongsTo('App\RequestDetail', 'request_id', 'request_id');
    }
}
