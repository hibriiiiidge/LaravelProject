<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMaker extends Model
{
  protected $fillable = [
    'category_id', 'maker_id', 'status', 'rgster', 'updter'
  ];

  //category_maker->item_category
  public function item_category(){
    return $this->belongsTo('App\ItemCategory');
  }

  //category_maker->item_maker
  public function item_maker(){
    return $this->belongsTo('App\ItemMaker');
  }
}
