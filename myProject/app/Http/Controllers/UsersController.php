<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\BaseType;

class UsersController extends Controller
{
  //スタッフ一覧表示
  public function index(){
    $users = DB::table('users')
            ->select('users.id AS u_id','users.name AS u_name', 'base_types.name AS b_name', 'users.email AS u_email', 'role_types.name AS r_name')
            ->leftJoin('base_types', 'users.base', '=', 'base_types.id')
            ->leftJoin('role_types', 'users.role', '=', 'role_types.id')
            ->where('users.status', '<>', 'X')
            ->orderBy('u_id', 'asc')
            ->get();

    return view('user.index', ['users' => $users]);
  }

  //スタッフ編集
  public function edit($id){
    $user = User::findOrFail($id);
    $baseTypes = BaseType::all();
    return view('user.edit', ['user' => $user, 'baseTypes' => $baseTypes]);
  }

  //スタッフupdate
  public function update(Request $request, $id){
    $this->validate($request, [
      'base'      => 'required|integer',
      'name'      => 'required|string|max:255',
      'email'     => 'required|string|email|max:255',
      'role'      => 'required|integer',
      'status'    => 'required',
      'updter'    => 'required|string',
    ]);
    $user = User::findOrFail($id);
    $user->base   = $request->base;       //所属拠点
    $user->name   = $request->name;       //氏名
    $user->email  = $request->email;      //メールアドレス
    $user->role   = $request->role;       //役割（ポジション）
    $user->status = $request->status;     //状態
    $user->updter = $request->updter;     //update担当者
    $user->save();
    return redirect('/users');
  }

  public function destroy($id){
    $user = User::findOrFail($id);
    $user->status = 'X';                  //論理削除、状態を"X"へ
    $user->save();
    return redirect('/users');
  }
}
