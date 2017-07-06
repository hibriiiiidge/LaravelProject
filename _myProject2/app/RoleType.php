<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{
    protected $fillable = [
      'id', 'name', 'status', 'rgster', 'updter'
    ];
}
