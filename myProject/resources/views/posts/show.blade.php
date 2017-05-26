@extends('layouts.default')

@section('title')
  LARAVEL SHOW
@endsection

@section('content')
  <h1>
    <a href="{{ url('/') }}" class="pull-right fs12">BACK</a>
    {{ $post->title }}
  </h1>
  <p>
    {!! nl2br(e($post->body)) !!}
  </p>

  <h2>Comment</h2>
  <ul>
    @forelse ($post->comments as $comment)
      <li>
        {{ $comment->body }}
        <form action="{{ action('CommentsController@destroy', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" id="form_{{ $comment->id  }}" method="post">
          {{ csrf_field() }}
          {{ method_field('delete') }}
          <a href="#" data-id="{{ $comment->id }}" onclick="deleteComment(this)" class="fs12">[X]</a>
        </form>
        {{-- <a href="{{ action('CommentsController@destroy', ['pos_id' => $post->id, 'comment_id' => $comment->id]) }}">[X]</a> --}}
      </li>
    @empty
      <li> NO Comments </li>
    @endforelse
  </ul>

  <h2>ADD NEW Comment</h2>
  <p>
    <form action="{{ action('CommentsController@store', $post->id) }}" method="post">
      {{ csrf_field() }}
      <p>
        <input type="text" name="body" value="{{ old('body') }}">
        @if ($errors->has('body'))
          <span class="error">{{ $errors->first('body') }}</span>
        @endif
      </p>
      <p>
        <input type="submit" value="登録">
      </p>
    </form>
  </p>

  <script>
  function deleteComment(e){
    'use strict';
    if (confirm('Are you sure?')) {
      document.getElementById('form_' + e.dataset.id).submit();
    }
  }
  </script>
@endsection
