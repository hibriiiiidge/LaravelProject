<div class="request_container">
    <div class="col-lg-12">
      <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="request_table">

                <tr class="form-group{{ $errors->has('urgency') ? ' has-error' : '' }}">
                  <th><label for="urgency" class="col-lg-12 control-label">緊急度</label></th>
                  <td>
                    <div class="col-lg-12">
                        <select id="urgency" class="form-control" name="urgency" autofocus>
                            <option value="">未選択</option>
                            <option value="1" {{ $requestDetail->urgency == 1 ? 'selected': '' }}>A</option>
                            <option value="2" {{ $requestDetail->urgency == 2 ? 'selected': '' }}>B</option>
                            <option value="3" {{ $requestDetail->urgency == 3 ? 'selected': '' }}>C</option>
                            <option value="4" {{ $requestDetail->urgency == 4 ? 'selected': '' }}>D</option>
                            <option value="5" {{ $requestDetail->urgency == 5 ? 'selected': '' }}>E</option>
                        </select>
                        @if ($errors->has('urgency'))
                            <span class="help-block">
                                <strong>{{ $errors->first('urgency') }}</strong>
                            </span>
                        @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                  <th><label for="reason" class="col-lg-12 control-label">動機</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="reason" class="form-control" name="reason" autofocus>
                          <option value="">未選択</option>
                          <option value="1" {{ $requestDetail->reason == 1 ? 'selected': '' }}>不要になったため</option>
                          <option value="2" {{ $requestDetail->reason == 2 ? 'selected': '' }}>引っ越しのため</option>
                          <option value="3" {{ $requestDetail->reason == 3 ? 'selected': '' }}>遺品整理のため</option>
                          <option value="3" {{ $requestDetail->reason == 4 ? 'selected': '' }}>その他</option>
                      </select>
                      @if ($errors->has('reason'))
                          <span class="help-block">
                              <strong>{{ $errors->first('reason') }}</strong>
                          </span>
                      @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('buy_way') ? ' has-error' : '' }}">
                  <th><label for="buy_way" class="col-lg-12 control-label">買取方法</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="buy_way" class="form-control" name="buy_way" autofocus>
                          <option value="">未選択</option>
                          <option value="1" {{ $requestDetail->buy_way == 1 ? 'selected': '' }}>宅配買取</option>
                          <option value="2" {{ $requestDetail->buy_way == 2 ? 'selected': '' }}>出張買取</option>
                          <option value="3" {{ $requestDetail->buy_way == 3 ? 'selected': '' }}>店頭買取</option>
                          <option value="4" {{ $requestDetail->buy_way == 4 ? 'selected': '' }}>未定</option>
                      </select>
                      @if ($errors->has('buy_way'))
                          <span class="help-block">
                              <strong>{{ $errors->first('buy_way') }}</strong>
                          </span>
                      @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('contact_way') ? ' has-error' : '' }}">
                  <th><label for="contact_way" class="col-lg-12 control-label">連絡方法</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="contact_way" class="form-control" name="contact_way" autofocus>
                          <option value="">未選択</option>
                          <option value="1" {{ $requestDetail->contact_way == 1 ? 'selected': '' }}>電話</option>
                          <option value="2" {{ $requestDetail->contact_way == 2 ? 'selected': '' }}>メール</option>
                          <option value="3" {{ $requestDetail->contact_way == 3 ? 'selected': '' }}>FAX</option>
                          <option value="4" {{ $requestDetail->contact_way == 4 ? 'selected': '' }}>連絡拒否</option>
                      </select>
                      @if ($errors->has('buy_way'))
                          <span class="help-block">
                              <strong>{{ $errors->first('buy_way') }}</strong>
                          </span>
                      @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('route') ? ' has-error' : '' }}">
                  <th><label for="route" class="col-lg-12 control-label">流入経路</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="route" class="form-control" name="route" autofocus>
                          <option value="">未選択</option>
                          <option value="1" {{ $requestDetail->route == 1 ? 'selected': '' }}>サイトA</option>
                          <option value="2" {{ $requestDetail->route == 2 ? 'selected': '' }}>サイトB</option>
                          <option value="3" {{ $requestDetail->route == 3 ? 'selected': '' }}>サイトC</option>
                      </select>
                      @if ($errors->has('route'))
                          <span class="help-block">
                              <strong>{{ $errors->first('route') }}</strong>
                          </span>
                      @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('competitive_flg') ? ' has-error' : '' }}">
                  <th><label for="competitive_flg" class="col-lg-12 control-label">相見積</label></th>
                  <td>
                    <div class="col-lg-12">
                        <input type="radio" name="competitive_flg" value="1" {{ $requestDetail->competitive_flg == 1 ? 'checked': '' }}>有
                        <input type="radio" name="competitive_flg" value="2" {{ $requestDetail->competitive_flg == 2 ? 'checked': '' }}>無
                        <input type="radio" name="competitive_flg" value="3" {{ $requestDetail->competitive_flg == 3 ? 'checked': '' }}>不明
                        @if ($errors->has('competitive_flg'))
                            <span class="help-block">
                                <strong>{{ $errors->first('competitive_flg') }}</strong>
                            </span>
                        @endif
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('summary_memo_main') ? ' has-error' : '' }}">
                  <th><label for="summary_memo_main" class="col-lg-12 control-label">概要メモ</label></th>
                  <td>
                    <div class="col-lg-12">
                        <textarea name="summary_memo_main" rows="8" cols="80" class="memo" data-type="main">{{  old('summary_memo_main', $requestDetail->summary_memo) }}</textarea>
                        @if ($errors->has('summary_memo_main'))
                            <span class="help-block">
                                <strong>{{ $errors->first('summary_memo_main') }}</strong>
                            </span>
                        @endif
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
      </div>
    </div>
</div>
