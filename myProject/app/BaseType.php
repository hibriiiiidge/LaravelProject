<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseType extends Model
{
    protected $fillable = [
      'name', 'postal_code', 'prefecture', 'address', 'tel', 'fax', 'mail', 'status', 'rgster', 'updter'
    ];
}
