<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable = [
      'name', 'status', 'rgster', 'updter'
    ];

    //item_category->category_makers
    public function category_makers(){
      return $this->hasMany('App\CategoryMaker');
    }
}
