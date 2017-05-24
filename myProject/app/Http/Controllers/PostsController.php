<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    //
    public function index(){
      $posts = Post::latest('created_at')->get();
      return view('posts.index', ['posts'=>$posts]);
    }

    public function show($id){
      $post = Post::findOrFail($id);
      // dd($post);
      return view('posts.show', ['post'=>$post]);
    }

    public function create(){
      return view('posts.create');
    }

    public function store(Request $request){
      $post = new Post();
      $post->title = $request->title;
      $post->body  = $request->body;
      $post->save();
      return redirect('/')->with('flash_message', '追加しました。');
    }
}
