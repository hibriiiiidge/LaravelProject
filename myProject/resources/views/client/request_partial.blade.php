<div class="request_container">
    <div class="col-lg-12">
      <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="request_table">

                <tr class="form-group">
                  <th><label for="urgency" class="col-lg-12 control-label">緊急度</label></th>
                  <td>
                    <div class="col-lg-2">
                        <select id="urgency" class="form-control" name="urgency" autofocus>
                            <option value="">未選択</option>
                            @foreach ($urgencys as $index => $urgency)
                              <option value="{{ $index }}" {{ $requestDetail->urgency == $index ? 'selected': '' }}>{{ $urgency }}</option>
                            @endforeach
                        </select>
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="reason" class="col-lg-12 control-label">動機</label></th>
                  <td>
                    <div class="col-lg-4">
                      <select id="reason" class="form-control" name="reason" autofocus>
                          <option value="">未選択</option>
                          @foreach ($reasons as $index => $reason)
                            <option value="{{ $index }}" {{ $requestDetail->reason == $index ? 'selected': '' }}>{{ $reason }}</option>
                          @endforeach
                      </select>
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="buy_way" class="col-lg-12 control-label">買取方法</label></th>
                  <td>
                    <div id="buy_way" class="col-lg-12">
                      @foreach ($buy_ways as $index => $buy_way)
                        <input type="radio" name="buy_way" value="{{ $index }}" {{ $requestDetail->buy_way == $index ? 'checked': '' }}>{{ $buy_way }}
                      @endforeach
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="contact_way" class="col-lg-12 control-label">連絡方法</label></th>
                  <td>
                    <div id="contact_way" class="col-lg-12">
                      @foreach ($contact_ways as $index => $contact_way)
                        <input type="radio" name="contact_way" value="{{ $index }}" {{ $requestDetail->contact_way == $index ? 'checked': '' }}>{{ $contact_way }}
                      @endforeach
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="route" class="col-lg-12 control-label">流入サイト</label></th>
                  <td>
                    <div class="col-lg-4">
                      <select id="route" class="form-control" name="route" autofocus>
                          <option value="">未選択</option>
                          @foreach ($routes as $route)
                            <option value="{{ $route->id }}" {{ $requestDetail->route == $route->id ? 'selected': '' }}>{{ $route->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="competitive_flg" class="col-lg-12 control-label">相見積</label></th>
                  <td>
                    <div class="col-lg-12">
                        <input type="radio" name="competitive_flg" value="1" {{ $requestDetail->competitive_flg == 1 ? 'checked': '' }}>有
                        <input type="radio" name="competitive_flg" value="2" {{ $requestDetail->competitive_flg == 2 ? 'checked': '' }}>無
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="summary_memo_main" class="col-lg-12 control-label">概要メモ</label></th>
                  <td>
                    <div class="col-lg-12">
                        <textarea name="summary_memo_main" rows="8" cols="80" class="memo" data-type="main">{{  old('summary_memo_main', $requestDetail->summary_memo) }}</textarea>
                    </div>
                  </td>
                </tr>


                <tr class="form-group">
                  <th><label for="bank_name" class="col-lg-12 control-label">金融機関名</label></th>
                  <td>
                    <div class="col-lg-4">
                      <span class="bnk_area">
                        <input type="text" name="bank_name" id="bank_name" class="form-control form_txt-short"  value="{{ old('bank_name', $requestDetail->bank_name) }}" placeholder="ex) ユーズド銀行" />
                      </span>
                      金融機関コード：<span id="bank_code">{{ $requestDetail->bank_code }}</span>
                      <input type="hidden" id="hd_bank_code" name="bank_code" value="">
                    </div>
                    <span id="bank_name_clear" class="bnk_clear btn btn-danger btn-xs">X</span>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="branch_name" class="col-lg-12 control-label">支店名</label></th>
                  <td>
                    <div class="col-lg-4">
                      <span class="bnk_area">
                        <input type="text" name="branch_name" id="branch_name" class="form-control form_txt-short" value="{{ old('branch_name', $requestDetail->branch_name) }}" placeholder="ex) ネット支店" />
                      </span>
                      支店コード：<span id="branch_code">{{ $requestDetail->branch_code }}</span>
                      <input type="hidden" id="hd_branch_code" name="branch_code" value="">
                    </div>
                    <span id="branch_name_clear" class="bnk_clear btn btn-danger btn-xs">X</span>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="account_kind" class="col-lg-12 control-label">預金種類</label></th>
                  <td>
                    <div class="col-lg-12">
                        <input type="radio" name="account_kind" value="1" {{ $requestDetail->account_kind == 1 ? 'checked': '' }}>普通
                        <input type="radio" name="account_kind" value="2" {{ $requestDetail->account_kind == 2 ? 'checked': '' }}>当座
                        <input type="radio" name="account_kind" value="3" {{ $requestDetail->account_kind == 3 ? 'checked': '' }}>貯蓄
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="account_number" class="col-lg-12 control-label">口座番号</label></th>
                  <td>
                    <div class="col-lg-3">
                        <input id="account_number" type="text" class="form-control" name="account_number" value="{{ old('account_number', $requestDetail->account_number) }}" placeholder="ex) 1234567" autofocus>
                        <span class="guide">半角</span>
                    </div>
                  </td>
                </tr>
                <tr class="form-group">
                  <th><label for="account_name" class="col-lg-12 control-label">口座名義人</label></th>
                  <td>
                    <div class="col-lg-4">
                        <input id="account_name" type="text" class="form-control" name="account_name" value="{{ old('account_name', $requestDetail->account_name) }}" placeholder="ex) ユーズド ネット" autofocus>
                        <span class="guide">カナ "セイ"と"ナ"の間に空白</span>
                    </div>
                  </td>
                </tr>
              </table>
              <div id="request_hidden">
                <input type="hidden" name="request_id" value="{{ $requestDetail->request_id }}">
              </div>
            </div>
          </div>
      </div>
    </div>
</div>
