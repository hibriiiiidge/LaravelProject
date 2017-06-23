<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaker extends Model
{
  protected $fillable = [
    'name', 'status', 'rgster', 'updter'
  ];

  //item_maker->item_categories
  public function item_categories(){
    return $this->belongsToMany('App\ItemCategory');
  }
}
