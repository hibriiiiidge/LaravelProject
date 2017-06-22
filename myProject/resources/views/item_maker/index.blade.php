@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">メーカー一覧</div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <td>ID</td>
                    <td>名称</td>
                    <td>使用状況</td>
                    <td>編集</td>
                  </thead>
                  <tbody>
                  @foreach ($item_makers as $item_maker)
                    <tr class="{{ $item_maker->status=='X' ? 'statusX' : ''}}">
                      <th>{{ $item_maker->id }}</th>
                      <td>{{ $item_maker->name }}</td>
                      <td>{{ $item_maker->status }}</td>
                      <td>
                        <a href="{{ action('ItemMakersController@edit', $item_maker->id) }}">
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
