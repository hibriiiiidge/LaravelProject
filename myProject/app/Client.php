<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
      'id', 'attribute', 'base', 'name', 'kana', 'gender', 'job', 'birth', 'tel',
      'mail', 'postal_code', 'prefecture', 'address', 'memo', 'status', 'rgster', 'updter',
      'fullname','first_name','first_name_kana','fax'
    ];

    public $incrementing = false;

    //client->request_details
    public function request_details(){
      return $this->hasMany('App\RequestDetail');
    }

}
