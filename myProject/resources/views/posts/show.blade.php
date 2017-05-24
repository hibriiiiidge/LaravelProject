@extends('layouts.default')

@section('title', 'Laravel SHOW')

@section('content')
  <h1>
    <a href="{{ url('/') }}" class="pull-right fs12">BACK</a>
    {{ $post->title }}
  </h1>
  <p>{!! nl2br(e($post->body)) !!}</p>
@endsection
