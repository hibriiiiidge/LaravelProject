@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">スタッフ一覧</div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <td>ID</td>
                    <td>氏名</td>
                    <td>拠点</td>
                    <td>アカウント</td>
                    <td>ポジション</td>
                    <td>在籍状況</td>
                    <td>編集</td>
                    {{-- <td>削除</td> --}}
                  </thead>
                  <tbody>
                  @foreach ($users as $user)
                    <tr class="{{ $user->u_status=='X' ? 'statusX':'' }}">
                      <th>{{ $user->u_id }}</th>
                      <td>{{ $user->u_name }}</td>
                      <td>{{ $user->b_name }}</td>
                      <td>{{ $user->u_email }}</td>
                      <td>{{ $user->r_name }}</td>
                      <td>{{ $user->u_status }}</td>
                      <td>
                        <a href="{{ action('UsersController@edit', $user->u_id) }}">
                          <button type="button" class="btn-sm btn-warning">
                            編集
                          </button>
                        </a>
                      </td>
                      {{-- <td>
                        <form action="{{ action('UsersController@destroy', $user->u_id) }}" id="form_{{ $user->u_id }}" method="post">
                          {{ csrf_field() }}
                          {{ method_field('delete') }}
                          <a href="#" data-id="{{ $user->u_id }}" onclick="deleteUser(this);" >
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
