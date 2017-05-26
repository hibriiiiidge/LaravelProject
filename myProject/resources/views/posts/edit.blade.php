@extends('layouts.default')

@section('title')
  LARAVEL EDIT
@endsection

@section('content')
  <h1>
    <a href="{{ url('/') }}" class="pull-right fs12">BACK</a>
    EDIT
  </h1>
  <p>
    <form action="{{ action('PostsController@update', $post->id) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('patch') }}
      <p>
        <input type="text" name="title" placeholder="title" value="{{ old('title', $post->title) }}">
        @if ($errors->has('title'))
          <span class="error">{{ $errors->first('title') }}</span>
        @endif
      </p>
      <p>
        <textarea name="body" placeholder="body">{{ old('body', $post->body) }}</textarea>
        @if ($errors->has('body'))
          <span class="error">{{ $errors->first('body') }}</span>
        @endif
      </p>
      <p>
        <input type="submit" value="UPDATE">
      </p>
    </form>
  </p>
@endsection
