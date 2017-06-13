<div class="item_container">
  <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="request_table">
              <tr class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                <th>
                  <label for="category" class="col-lg-12 control-label">カテゴリー</label>
                </th>
                <td>
                  <div class="col-lg-12">
                      <select id="category" class="form-control" name="category[]" autofocus>
                          <option value="">未選択</option>
                          <option value="1" {{ $item->category == 1 ? 'selected': '' }}>パソコン</option>
                          <option value="2" {{ $item->category == 2 ? 'selected': '' }}>オーディオ</option>
                          <option value="3" {{ $item->category == 3 ? 'selected': '' }}>カメラ</option>
                      </select>
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('item_name') ? ' has-error' : '' }}">
                <th><label for="item_name" class="col-lg-12 control-label">商品名</label></th>
                <td>
                  <div class="col-lg-12">
                      <input id="item_name" type="text" class="form-control" name="item_name[]" value="{{ old('item_name', $item->name) }}">
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('outside_condition') ? ' has-error' : '' }}">
                <th><label for="outside_condition" class="col-lg-12 control-label">外観の状態</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="1" {{ $item->outside_condition == 1 ? 'checked': '' }}>新品
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="2" {{ $item->outside_condition == 2 ? 'checked': '' }}>ほぼ新品
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="3" {{ $item->outside_condition == 3 ? 'checked': '' }}>非常に良い
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="4" {{ $item->outside_condition == 4 ? 'checked': '' }}>良い
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="5" {{ $item->outside_condition == 5 ? 'checked': '' }}>可
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="6" {{ $item->outside_condition == 6 ? 'checked': '' }}>難あり
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('inside_condition') ? ' has-error' : '' }}">
                <th><label for="inside_condition" class="col-lg-12 control-label">動作状況</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="1" {{ $item->inside_condition == 1 ? 'checked': '' }}>保証品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="2" {{ $item->inside_condition == 2 ? 'checked': '' }}>未開封品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="3" {{ $item->inside_condition == 3 ? 'checked': '' }}>未使用品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="4" {{ $item->inside_condition == 4 ? 'checked': '' }}>現状品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="5" {{ $item->inside_condition == 5 ? 'checked': '' }}>ジャンク品
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('cooling_off_flg') ? ' has-error' : '' }}">
                <th><label for="cooling_off_flg" class="col-lg-12 control-label">クーリングオフの有無</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="1" {{ $item->cooling_off_flg == 1 ? 'checked': '' }}>対象
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="2" {{ $item->cooling_off_flg == 2 ? 'checked': '' }}>対象外
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="3" {{ $item->cooling_off_flg == 3 ? 'checked': '' }}>不明
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('item_memo') ? ' has-error' : '' }}">
                <th><label for="item_memo" class="col-lg-12 control-label">特記事項</label></th>
                <td>
                  <div class="col-lg-12">
                      <textarea name="item_memo[]" rows="8" cols="80" id="item_memo">{{ old('item_memo', $item->memo) }}</textarea>
                  </div>
                </td>
              </tr>
            </table>
            <div class="item_hidden">
              <input type="hidden" name="item_status" value="◯">
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
