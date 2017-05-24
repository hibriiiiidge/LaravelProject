@extends('layouts.default')

@section('title', 'Laravel POST')

@section('content')
  <h1>
    <a href="{{ url('/posts/create') }}" class="pull-right fs12">ADD NEW</a>
    POST
  </h1>
  @forelse ($posts as $post)
    <li><a href="{{ url('/posts', $post->id) }}">{{ $post->title }}</a></li>
  @empty
    <li>No POST YET</li>
  @endforelse
@endsection
