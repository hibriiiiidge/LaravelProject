<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaker extends Model
{
  protected $fillable = [
    'name', 'status', 'rgster', 'updter'
  ];

  //item_maker->category_makers
  public function category_makers(){
    return $this->hasMany('App\CategoryMaker');
  }
}
