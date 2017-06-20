<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BaseType;

class BaseTypesController extends Controller
{
    public function create(){
      $prefs = config('pref'); //都道府県取得
      return view('basetype.register',[
        'prefs' => $prefs
      ]);
    }

    public function store(Request $request){
      //dd($request);
      //@TODO $request バリデーション
      $base = new BaseType();
      $base->name         = $request->b_name;
      $base->short_name   = $request->b_short_name;
      $base->postal_code  = $request->b_postal_code;
      $base->prefecture   = $request->b_prefecture;
      $base->address      = $request->b_address;
      $base->tel          = $request->b_tel;
      $base->fax          = $request->b_fax;
      $base->mail         = $request->b_mail;
      $base->status       = $request->b_status;
      $base->rgster       = $request->b_rgster;
      $base->updter       = $request->b_updter;
      $base->save();
      $bases = DB::table('base_types')
                  ->orderBy('id', 'asc')
                  ->get();
      $prefs = config('pref'); //都道府県取得
      return redirect('/home');
    }

    public function index(){
      $bases = DB::table('base_types')
                  ->orderBy('id', 'asc')
                  ->get();
      $prefs = config('pref');
      return view('basetype.index',[
          'bases' => $bases,
          'prefs' => $prefs
      ]);
    }
}
