@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">カテゴリー・メーカー関連登録</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ action('CategoryMakerController@store') }}">
                      {{ csrf_field() }}
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <td></td>
                            @foreach ($categories as $category)
                              <td>{{ $category->name }}</td>
                            @endforeach
                          </thead>
                          <tbody>
                            @foreach ($makers as $maker)
                              <tr class="">
                                <td>{{ $maker->name }}</td>
                                @foreach ($categories as $category)
                                  <td><input type="checkbox" name="cate_maker[]" value="{{ $category->id }}-{{ $maker->id }}"></td>
                                @endforeach
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div>
                        <input type="hidden" name="cm_status" value="◯">
                        <input type="hidden" name="cm_rgster" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="cm_updter" value="{{ Auth::user()->id }}">
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
