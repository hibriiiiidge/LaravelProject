<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemProgress extends Model
{
    protected $fillable = [
      'item_id', 'flow_no', 'progress_status', 'progress_memo',
      'status', 'rgster', 'updter'
    ];

    protected $touches = array('item');

    //item_progresses->item
    public function item(){
      return $this->belongsTo('App\Item', 'item_id', 'id');
    }
}
