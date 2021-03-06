@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">カテゴリー・メーカー関連編集</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ action('CategoryMakerController@update') }}">
                      {{ csrf_field() }}
                      {{ method_field('patch') }}
                      @include('category_maker.form_partial')
                      <div>
                        <input type="hidden" name="cm_status" value="◯">
                        <input type="hidden" name="cm_rgster" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="cm_updter" value="{{ Auth::user()->id }}">
                      </div>
                      <div class="form-group">
                          <div class="col-md-2 col-md-offset-10" id="cate_maker_rgst_btn">
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
