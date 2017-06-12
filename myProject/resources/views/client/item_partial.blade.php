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
                      <select id="category" class="form-control" name="category" autofocus>
                          <option value="">未選択</option>
                          <option value="1">パソコン</option>
                          <option value="2">オーディオ</option>
                          <option value="3">カメラ</option>
                      </select>
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('item_name') ? ' has-error' : '' }}">
                <th><label for="item_name" class="col-lg-12 control-label">商品名</label></th>
                <td>
                  <div class="col-lg-12">
                      <input id="item_name" type="text" class="form-control" name="item_name">
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('outside_condition') ? ' has-error' : '' }}">
                <th><label for="outside_condition" class="col-lg-12 control-label">外観の状態</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="outside_condition" name="outside_condition" value="1">新品
                    <input type="radio" class="outside_condition" name="outside_condition" value="2">ほぼ新品
                    <input type="radio" class="outside_condition" name="outside_condition" value="3">非常に良い
                    <input type="radio" class="outside_condition" name="outside_condition" value="4">良い
                    <input type="radio" class="outside_condition" name="outside_condition" value="5">可
                    <input type="radio" class="outside_condition" name="outside_condition" value="6">難あり
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('inside_condition') ? ' has-error' : '' }}">
                <th><label for="inside_condition" class="col-lg-12 control-label">外観の状態</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="inside_condition" name="inside_condition" value="1">保証品
                    <input type="radio" class="inside_condition" name="inside_condition" value="2">未開封品
                    <input type="radio" class="inside_condition" name="inside_condition" value="3">未使用品
                    <input type="radio" class="inside_condition" name="inside_condition" value="4">現状品
                    <input type="radio" class="inside_condition" name="inside_condition" value="5">ジャンク品
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('cooling_off_flg') ? ' has-error' : '' }}">
                <th><label for="cooling_off_flg" class="col-lg-12 control-label">クーリングオフの有無</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg" value="1">対象
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg" value="2">対象外
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg" value="3">不明
                  </div>
                </td>
              </tr>
              <tr class="form-group{{ $errors->has('item_memo') ? ' has-error' : '' }}">
                <th><label for="item_memo" class="col-lg-12 control-label">特記事項</label></th>
                <td>
                  <div class="col-lg-12">
                      <textarea name="item_memo" rows="8" cols="80" id="item_memo"></textarea>
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
