<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable = [
      'name', 'status', 'rgster', 'updter'
    ];

    //item_category->item_makers
    public function item_makers(){
      return $this->belongsToMany('App\ItemMaker');
    }
}
