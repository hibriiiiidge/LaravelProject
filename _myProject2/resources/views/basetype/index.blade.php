@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">拠点一覧</div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <td>ID</td>
                    <td>名称</td>
                    <td>省略名</td>
                    <td>郵便番号</td>
                    <td>都道府県</td>
                    <td>住所</td>
                    <td>tel</td>
                    <td>fax</td>
                    <td>mail</td>
                    <td>営業状況</td>
                    <td>編集</td>
                  </thead>
                  <tbody>
                  @foreach ($bases as $base)
                    <tr class="{{ $base->status=='X' ? 'statusX' : ''}}">
                      <th>{{ $base->id }}</th>
                      <td>{{ $base->name }}</td>
                      <td>{{ $base->short_name }}</td>
                      <td>{{ $base->postal_code }}</td>
                      <td>{{ $prefs[$base->prefecture] }}</td>
                      <td>{{ $base->address }}</td>
                      <td>{{ $base->tel }}</td>
                      <td>{{ $base->fax }}</td>
                      <td>{{ $base->mail }}</td>
                      <td>{{ $base->status }}</td>
                      <td>
                        <a href="{{ action('BaseTypesController@edit', $base->id) }}">
                          <button type="button" class="btn-sm btn-warning">
                            編集
                          </button>
                        </a>
                      </td>
                      {{--
                      削除という概念はなし 削除->徹底 として編集により対応
                      <td>
                        <form action="" id="form" method="post">
                          {{ csrf_field() }}
                          {{ method_field('delete') }}
                          <a href="#" data-id="" onclick="" >
                            <button type="button" class="btn-sm btn-danger">
                                削除
                            </button>
                          </a>
                        </form>
                      </td> --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!--/table-responsive-->
          </div><!--/panel-->
        </div>
    </div>
</div>

{{-- <script>
  function deleteUser(e){
    if(confirm('本当に削除しますか？')){
      document.getElementById('form_' + e.dataset.id).submit();
    }
  }
</script> --}}
@endsection
