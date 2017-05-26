@extends('layouts.default')

@section('title')
  LARAVEL LIST
@endsection

@section('content')
  <h1>
    <a href="{{ action('PostsController@create') }}" class="pull-right fs12">NEW POST</a>
    POSTS
  </h1>
  <ul>
    @forelse ($posts as $post)
      <li>
        <a href="{{ action('PostsController@show', $post->id) }}">{{ $post->title }}</a>
        <a href="{{ action('PostsController@edit', $post->id) }}">[EDIT]</a>
        <form action="{{ action('PostsController@destroy', $post->id) }}" id="form_{{ $post->id }}" method="post" style="display:inline">
          {{ csrf_field() }}
          {{ method_field('delete') }}
          <p><a href="#" data-id="{{ $post->id }}" onclick="deletePost(this);" class="fs12">[X]</a></p>
        </form>
        {{-- <a href="{{ action('PostsController@destroy', $post->id) }}">[X]</a> --}}
      </li>
    @empty
      <li>NO Post yet</li>
    @endforelse
  </ul>

<script>
function deletePost(e){
  'use strict'

  if(confirm('Are you sure?')){
    document.getElementById("form_" + e.dataset.id).submit();
  }
}
</script>

@endsection
