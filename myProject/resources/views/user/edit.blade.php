@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">スタッフ編集</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ action('UsersController@update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="form-group{{ $errors->has('base') ? ' has-error' : '' }}">
                            <label for="base" class="col-md-4 control-label">拠点</label>

                            <div class="col-md-6">
                                <select id="base" class="form-control" name="base" required autofocus>
                                  <option value=" ">未選択</option>
                                  @foreach ($baseTypes as $baseType)
                                    <option value="{{ $baseType->id }}" {{ $baseType->id == $user->base ? 'selected': '' }}>{{ $baseType->name }}</option>
                                  @endforeach
                                </select>

                                @if ($errors->has('base'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('base') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名前</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">ポジション</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" required autofocus>
                                  <option value="0"   {{ $user->role==0   ? 'selected': '' }}>未選択</option>
                                  <option value="1"   {{ $user->role==1   ? 'selected': '' }}>マスター</option>
                                  <option value="50"  {{ $user->role==50  ? 'selected': '' }}>システム事業部</option>
                                  <option value="100" {{ $user->role==100 ? 'selected': '' }}>一般</option>
                                </select>

                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">在籍の有無</label>

                            <div class="col-md-6">
                                <select id="status" class="form-control" name="status" required autofocus>
                                  <option value="◯">有</option>
                                  <option value="X">無（退職済）</option>
                                </select>
                            </div>
                        </div>

                        <div>
                          <input type="hidden" name="updter" value="{{ Auth::user()->id }}">
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
