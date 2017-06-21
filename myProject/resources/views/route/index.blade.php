@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">流入サイト一覧</div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <td>ID</td>
                    <td>名称</td>
                    <td>URL</td>
                    <td>公開状況</td>
                    <td>編集</td>
                  </thead>
                  <tbody>
                  @foreach ($routes as $route)
                    <tr class="{{ $route->status=='X' ? 'statusX' : ''}}">
                      <th>{{ $route->id }}</th>
                      <td>{{ $route->name }}</td>
                      <td><a href="{{ $route->url }}" target="_blank">{{ $route->url }}</a></td>
                      <td>{{ $route->status }}</td>
                      <td>
                        <a href="{{ action('RoutesController@edit', $route->id) }}">
                          <button type="button" class="btn-sm btn-warning">
                            編集
                          </button>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!--/table-responsive-->
          </div><!--/panel-->
        </div>
    </div>
</div>
@endsection
