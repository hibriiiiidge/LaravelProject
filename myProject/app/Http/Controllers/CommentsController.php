<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
  public function store(Request $request, $postId){
    $this->validate($request, [
      'body' => 'required'
    ]);

    $post    = Post::findOrFail($postId);
    $comment = new Comment();
    $comment->post_id = $postId;
    $comment->body = $request->body;
    $comment->save();
    return redirect()->action('PostsController@show', ['post' => $post]);
  }

  public function destroy($postId, $commentId){
    $post = Post::findOrFail($postId);
    $x = $post->comments()->findOrFail($commentId);
    $post->comments()->findOrFail($commentId)->delete();
    return redirect()->action('PostsController@show', ['post' => $post]);
  }
}
