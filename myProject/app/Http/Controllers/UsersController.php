<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\BaseType;

class UsersController extends Controller
{
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

  public function edit($id){
    $user = User::findOrFail($id);
    $baseTypes = BaseType::all();
    return view('user.edit', ['user' => $user, 'baseTypes' => $baseTypes]);
  }

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
    $user->base   = $request->base;
    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->role   = $request->role;
    $user->status = $request->status;
    $user->updter = $request->updter;
    $user->save();
    return redirect('/users');
  }

  public function destroy($id){
    $user = User::findOrFail($id);
    $user->status = 'X';
    $user->save();
    return redirect('/users');
  }
}
