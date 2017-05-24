@extends('layouts.default')

@section('title', 'ADD NEW')

@section('content')
  <h1>
    <a href="{{ url('/') }}" class="pull-right fs12">BACK</a>
    ADD NEW
  </h1>
  <form method="post" action="{{ url('/posts') }}">
    {{ csrf_field() }}
    <p>
      <input type="text" name="title" placeholder="title">
    </p>
    <p>
      <textarea name="body" placeholder="body"></textarea>
    </p>
    <p>
      <input type="submit" name="addnew">
    </p>
  </form>
@endsection
