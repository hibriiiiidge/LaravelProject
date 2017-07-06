@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">拠点編集</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ action('BaseTypesController@update', $base->id) }}">
                      {{ csrf_field() }}
                      {{ method_field('patch') }}
                      @include('basetype.form_partial')
                      <div>
                        <input type="hidden" name="b_updter" value="{{ Auth::user()->id }}">
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary">
                                  編集
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
