@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">新規メーカー登録</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ action('ItemMakersController@store') }}">
                      {{ csrf_field() }}
                      @include('item_maker.form_partial')
                      <div>
                        <input type="hidden" name="ic_rgster" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="ic_updter" value="{{ Auth::user()->id }}">
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary">
                                  登録
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
