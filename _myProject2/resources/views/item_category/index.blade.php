@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">商品カテゴリー一覧</div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <td>ID</td>
                    <td>名称</td>
                    <td>確認項目</td>
                    <td>使用状況</td>
                    <td>編集</td>
                  </thead>
                  <tbody>
                  @foreach ($item_categories as $item_category)
                    <tr class="{{ $item_category->status=='X' ? 'statusX' : ''}}">
                      <th>{{ $item_category->id }}</th>
                      <td>{{ $item_category->name }}</td>
                      <td>{!! nl2br(e($item_category->check_list)) !!}</td>
                      <td>{{ $item_category->status }}</td>
                      <td>
                        <a href="{{ action('ItemCategoriesController@edit', $item_category->id) }}">
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
