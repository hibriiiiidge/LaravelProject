<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
  protected $fillable = [
    'name', 'url', 'status', 'rgster', 'updter'
  ];
}
