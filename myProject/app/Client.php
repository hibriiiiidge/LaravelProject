<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
      'id', 'attribute', 'base', 'name', 'kana', 'gender', 'job', 'birth', 'tel',
      'mail', 'postal_code', 'prefecture', 'address', 'memo', 'status', 'rgster', 'updter'
    ];
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
