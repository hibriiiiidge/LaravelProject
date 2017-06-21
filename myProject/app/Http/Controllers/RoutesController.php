<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Route;

class RoutesController extends Controller
{
    public function index(){
      $routes = DB::table('routes')
                  ->orderBy('status', 'asc')
                  ->get();
      return view('route.index',[
          'routes' => $routes,
      ]);
    }

    public function create(){
      $route = new Route();
      return view('route.register', ['route' => $route]);
    }

    public function store(Request $request){
      //dd($request);
      //@TODO $request バリデーション
      $route = new Route();
      $route->name         = $request->rt_name;
      $route->url          = $request->rt_url;
      $route->status       = $request->rt_status;
      $route->rgster       = $request->rt_rgster;
      $route->updter       = $request->rt_updter;
      $route->save();
      $routes = DB::table('routes')
                  ->orderBy('status', 'asc')
                  ->orderBy('id', 'asc')
                  ->get();
      return redirect('/routes');
    }

    public function edit($routeId){
      $route = Route::findOrFail($routeId);
      return view('route.edit', ['route' => $route]);
    }

    public function update(Request $request, $routeId){
      //dd($request);
      //@TODO $request バリデーション
      $route = Route::findOrFail($routeId);
      $route->name         = $request->rt_name;
      $route->url   = $request->rt_url;
      $route->status       = $request->rt_status;
      $route->updter       = $request->rt_updter;
      $route->save();
      $routes = DB::table('routes')
                  ->orderBy('status', 'asc')
                  ->orderBy('id', 'asc')
                  ->get();
      return redirect('/routes');
    }
}
