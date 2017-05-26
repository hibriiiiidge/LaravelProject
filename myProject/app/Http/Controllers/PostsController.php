<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index(){
      $posts = Post::latest('created_at')->get();
      return view('posts.index', ['posts' => $posts]);
    }

    public function show($id){
      $post = Post::findOrFail($id);
      return view('posts.show', ['post' => $post]);
    }

    public function edit($id){
      $post = Post::findOrFail($id);
      return view('posts.edit', ['post' => $post]);
    }

    public function create(){
      return view('posts.create');
    }

    public function destroy($id){
      $post = Post::findOrFail($id);
      $post->delete();
      return redirect('/')->with('flash_message', 'Delete!!!');
    }

    public function store(PostRequest $request){
      $post = new Post();
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/')->with('flash_message', 'ADD!');
    }

    public function update(PostRequest $request, $id){
      $post = Post::findOrFail($id);
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/')->with('flash_message', 'Update!');
    }
}
