@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">新規拠点登録</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ action('BaseTypesController@store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="b_name" class="col-md-4 control-label">名称</label>
                            <div class="col-md-6">
                                <input id="b_name" type="text" class="form-control" name="b_name" value="{{ old('b_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="b_short_name" class="col-md-4 control-label">省略名称(3文字以内)</label>
                            <div class="col-md-6">
                                <input id="b_short_name" type="text" class="form-control" name="b_short_name" value="{{ old('b_short_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="b_postal_code" class="col-md-4 control-label">郵便番号</label>
                            <div class="col-md-6">
                                <input id="b_postal_code" type="text" class="form-control postal_code" name="b_postal_code" value="{{ old('b_postal_code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="b_prefecture" class="col-md-4 control-label">都道府県</label>
                          <div class="col-md-6">
                            <select id="b_prefecture" class="form-control" name="b_prefecture" autofocus>
                              <option value="">未選択</option>
                              @foreach ($prefs as $index => $name)
                                <option value="{{ $index }}">{{ $name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="b_address" class="col-md-4 control-label">住所</label>
                          <div class="col-md-6">
                              <input id="b_address" type="text" class="form-control" name="b_address" value="{{ old('b_address') }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="b_tel" class="col-md-4 control-label">TEL</label>
                            <div class="col-md-6">
                                <input id="b_tel" type="tel" class="form-control" name="b_tel" value="{{ old('b_tel') }}">
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="b_fax" class="col-md-4 control-label">FAX</label>
                            <div class="col-md-6">
                                <input id="b_fax" type="tel" class="form-control" name="b_fax" value="{{ old('b_fax') }}">
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="b_mail" class="col-md-4 control-label">MAIL</label>
                            <div class="col-md-6">
                                <input id="b_mail" type="email" class="form-control" name="b_mail" value="{{ old('b_mail') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="b_status" class="col-md-4 control-label">営業の有無</label>
                            <div class="col-md-6">
                                <select id="b_status" class="form-control" name="b_status" required autofocus>
                                  <option value="◯">営業中</option>
                                  <option value="X">撤退</option>
                                </select>
                            </div>
                        </div>
                        <div>
                          <input type="hidden" name="b_rgster" value="{{ Auth::user()->id }}">
                          <input type="hidden" name="b_updter" value="{{ Auth::user()->id }}">
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
