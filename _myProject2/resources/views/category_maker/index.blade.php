@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="master_table col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">カテゴリー・メーカー関連表</div>
            <!-- Table -->
            <div class="table-responsive">
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
                          <td class="check">
                          @foreach ($categories_makers as $category_maker)
                              @if ($category->id."-".$maker->id == $category_maker->category_id."-".$category_maker->maker_id)
                                ●
                              @endif
                          @endforeach
                        </td><!-- @TODO 該当しない場合の表示は本当は'-'にしたい。controllerを修正する必要あり-->
                        @endforeach
                      </tr>
                    @endforeach
                </tbody>
              </table>
            </div><!--/table-responsive-->
          </div><!--/panel-->
          <div class="col-lg-1 col-lg-offset-11">
            <a href="{{ action('CategoryMakerController@edit') }}">
              <button type="button" class="btn-sm btn-warning">
                編集
              </button>
            </a>
          </div>
        </div>
    </div>
</div>
@endsection
