<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable = [
      'name', 'status', 'rgster', 'updter'
    ];
}
