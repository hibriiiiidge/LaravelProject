<div class="item_container">
  <div class="col-lg-12">
    <div class="panel panel-default">
      @if ($item->status=="R")
        <div class="return_block">
          ==================== 返品 ====================
          <div class="reason_block">
            <div class="return_title">
              返品理由：
            </div>
            <div class="return_reason">
              {!! nl2br(e($item->return_reason)) !!}
            </div>
          </div>
        </div>
      @endif
        <div class="panel-body">
          <div class="table-responsive" style="clear:both;">
            <table class="table table-striped table-hover" id="request_table">
              <tr class="form-group">
                <th>
                  <label for="category" class="col-lg-12 control-label">カテゴリー</label>
                </th>
                <td>
                  <div class="col-lg-12">
                      <select id="category{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}" class="form-control select_cat" name="category[]" autofocus {{ $item->status == "R" ? 'disabled': '' }}>
                          <option value="">未選択</option>
                          @foreach ($item_categories as $item_category)
                            <option value="{{ $item_category->id }}" {{ $item->category == $item_category->id ? 'selected': '' }}>{{ $item_category->name }}</option>
                          @endforeach
                      </select>
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th>
                  <label for="maker" class="col-lg-12 control-label">メーカー</label>
                </th>
                <td>
                  <div class="col-lg-12">
                      <select id="maker{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}" class="form-control select_maker" name="maker[]" autofocus {{ $item->status == "R" ? 'disabled': '' }}>
                          <option value="">未選択</option>
                          @foreach ($item_makers as $item_maker)
                            <option value="{{ $item_maker->id }}" {{ $item->maker == $item_maker->id ? 'selected': '' }}>{{ $item_maker->name }}</option>
                          @endforeach
                      </select>
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="item_name" class="col-lg-12 control-label">商品名</label></th>
                <td>
                  <div class="col-lg-12">
                      <input id="item_name{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}" type="text" class="form-control" name="item_name[]" value="{{ old('item_name', $item->name) }}" {{ $item->status == "R" ? 'disabled': '' }}>
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="outside_condition" id="" class="col-lg-12 control-label">外観の状態</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="0" {{ $item->outside_condition == 0 ? 'checked': '' }} checked {{ $item->status == "R" ? 'disabled': '' }}>未確認
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="1" {{ $item->outside_condition == 1 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>新品
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="2" {{ $item->outside_condition == 2 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>ほぼ新品
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="3" {{ $item->outside_condition == 3 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>非常に良い
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="4" {{ $item->outside_condition == 4 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>良い
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="5" {{ $item->outside_condition == 5 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>可
                    <input type="radio" class="outside_condition" name="outside_condition[{{$item->no_underscore_id}}]" value="6" {{ $item->outside_condition == 6 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>難あり
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="inside_condition" class="col-lg-12 control-label">動作状況</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="0" {{ $item->inside_condition == 0 ? 'checked': '' }} checked {{ $item->status == "R" ? 'disabled': '' }}>未確認
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="1" {{ $item->inside_condition == 1 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>保証品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="2" {{ $item->inside_condition == 2 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>未開封品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="3" {{ $item->inside_condition == 3 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>未使用品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="4" {{ $item->inside_condition == 4 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>現状品
                    <input type="radio" class="inside_condition" name="inside_condition[{{$item->no_underscore_id}}]" value="5" {{ $item->inside_condition == 5 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>ジャンク品
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="cooling_off_flg" class="col-lg-12 control-label">クーリングオフの有無</label></th>
                <td>
                  <div class="col-lg-12">
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="0" {{ $item->cooling_off_flg == 3 ? 'checked': '' }} checked {{ $item->status == "R" ? 'disabled': '' }}>未確認
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="1" {{ $item->cooling_off_flg == 1 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>対象
                    <input type="radio" class="cooling_off_flg" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="2" {{ $item->cooling_off_flg == 2 ? 'checked': '' }} {{ $item->status == "R" ? 'disabled': '' }}>対象外
                  </div>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="item_memo" class="col-lg-12 control-label">特記事項</label></th>
                <td>
                  <div class="col-lg-12">
                      <textarea name="item_memo[]" rows="8" cols="80" id="item_memo" {{ $item->status == "R" ? 'disabled': '' }}>{{ old('item_memo', $item->memo) }}</textarea>
                  </div>
                </td>
              </tr>

              <tr class="form-group">
                <th><label for="estimate_price" class="col-lg-12 control-label">見積提示額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="estimate_price{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price estimate_price" name="estimate_price[]" value="{{ nf($item->estimate_price) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="expsell_price" class="col-lg-12 control-label">見込販売額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="expsell_min_price{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price expsell_min_price" name="expsell_min_price[]" value="{{ nf($item->expsell_min_price) }}">
                  </div>
                  <span class="yen">円</span>
                  <div class="price wave">
                    〜
                  </div>
                  <div class="col-lg-2 tr_price">
                      <input id="expsell_max_price{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price expsell_max_price" name="expsell_max_price[]" value="{{ nf($item->expsell_max_price) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="exp_profit" class="col-lg-12 control-label">見込粗利額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="exp_min_profit{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="exp_min_profit[]" value="{{ nf($item->exp_min_profit) }}">
                  </div>
                  <span class="yen">円</span>
                  <div class="price wave">
                    〜
                  </div>
                  <div class="col-lg-2 tr_price">
                      <input id="exp_max_profit{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="exp_max_profit[]" value="{{ nf($item->exp_max_profit) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="exp_profrate" class="col-lg-12 control-label">見込粗利率</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="exp_min_profit_rate{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="exp_min_profit_rate[]" value="{{ $item->exp_min_profit_rate }}">
                  </div>
                  <span class="yen">%</span>
                  <div class="price wave">
                    〜
                  </div>
                  <div class="col-lg-2 tr_price">
                      <input id="exp_max_profit_rate{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="exp_max_profit_rate[]" value="{{ $item->exp_max_profit_rate }}">
                  </div>
                  <span class="yen">%</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="buy_price" class="col-lg-12 control-label">買取額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="buy_price{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price buy_price" name="buy_price[]" value="{{ nf($item->buy_price) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="sell_price" class="col-lg-12 control-label">販売額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="sell_price{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price sell_price" name="sell_price[]" value="{{ nf($item->sell_price) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="profit" class="col-lg-12 control-label">粗利額</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="profit{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="profit[]" value="{{ nf($item->profit) }}">
                  </div>
                  <span class="yen">円</span>
                </td>
              </tr>
              <tr class="form-group">
                <th><label for="profit_rate" class="col-lg-12 control-label">粗利率</label></th>
                <td>
                  <div class="col-lg-2 tr_price">
                      <input id="profit_rate{{ $item->no_underscore_id ? "_".$item->no_underscore_id: ''  }}"  type="text" class="form-control price" name="profit_rate[]" value="{{ $item->profit_rate }}">
                  </div>
                  <span class="yen">%</span>
                </td>
              </tr>

              <tr id="return_reason_{{$item->no_underscore_id}}" class="form-group" style="display:none;">
                <th><label for="item_memo" class="col-lg-12 control-label" style="color:#ffffff">返品理由</label></th>
                <td>
                  <div class="col-lg-12">
                      <textarea name="return_reasons[]" rows="8" cols="80"></textarea>
                  </div>
                </td>
              </tr>

            </table>
            <div class="item_hidden">
              <input type="hidden" name="item_status" value="◯">
              <input type="hidden" id="return_item_{{$item->no_underscore_id}}" name="return_items[]" value="">
              @if ($item->status=="R")
                {{-- @TODO price関連のdisabledを追加する--}}
                <input type="hidden" name="category[]" value="{{ $item->category }}">
                <input type="hidden" name="item_name[]" value="{{ $item->item_name }}">
                <input type="hidden" name="outside_condition[{{$item->no_underscore_id}}]" value="{{ $item->outside_condition }}">
                <input type="hidden" name="inside_condition[{{$item->no_underscore_id}}]" value="{{ $item->inside_condition }}">
                <input type="hidden" name="cooling_off_flg[{{$item->no_underscore_id}}]" value="{{ $item->cooling_off_flg }}">
                <input type="hidden" name="item_memo[]" value="{{ $item->memo }}">
              @endif
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

@if ($prg_nums['transport'] < $latestSts && $latestSts < $prg_nums['agreement'] )
  @unless ($item->status=="R")
  <div id="item_return_{{$item->no_underscore_id}}" class="return_btn_edit">
    <button type="button" id="return_btn_{{$item->no_underscore_id}}" class="btn btn-warning">返品</button>
  </div>
  @endunless
@else
  @if ($prg_nums['agreement'] < $latestSts && $itemsCnt && $itemsCnt > 1)
    <div id="item_delete_{{$item->no_underscore_id}}" class="delete_btn_edit">
      <button type="button" id="delete_btn_{{$item->no_underscore_id}}" class="btn btn-danger">削除</button>
    </div>
  @endif
@endif
