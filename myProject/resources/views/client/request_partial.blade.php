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
                            @foreach ($urgencys as $index => $urgency)
                              <option value="{{ $index }}" {{ $requestDetail->urgency == $index ? 'selected': '' }}>{{ $urgency }}</option>
                            @endforeach
                        </select>
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                  <th><label for="reason" class="col-lg-12 control-label">動機</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="reason" class="form-control" name="reason" autofocus>
                          <option value="">未選択</option>
                          @foreach ($reasons as $index => $reason)
                            <option value="{{ $index }}" {{ $requestDetail->reason == $index ? 'selected': '' }}>{{ $reason }}</option>
                          @endforeach
                      </select>
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('buy_way') ? ' has-error' : '' }}">
                  <th><label for="buy_way" class="col-lg-12 control-label">買取方法</label></th>
                  <td>
                    <div id="buy_way" class="col-lg-12">
                      @foreach ($buy_ways as $index => $buy_way)
                        <input type="radio" name="buy_way" value="{{ $index }}" {{ $requestDetail->buy_way == $index ? 'checked': '' }}>{{ $buy_way }}
                      @endforeach
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('contact_way') ? ' has-error' : '' }}">
                  <th><label for="contact_way" class="col-lg-12 control-label">連絡方法</label></th>
                  <td>
                    <div id="contact_way" class="col-lg-12">
                      @foreach ($contact_ways as $index => $contact_way)
                        <input type="radio" name="contact_way" value="{{ $index }}" {{ $requestDetail->buy_way == $index ? 'checked': '' }}>{{ $contact_way }}
                      @endforeach
                    </div>
                  </td>
                </tr>
                <tr class="form-group{{ $errors->has('route') ? ' has-error' : '' }}">
                  <th><label for="route" class="col-lg-12 control-label">流入サイト</label></th>
                  <td>
                    <div class="col-lg-12">
                      <select id="route" class="form-control" name="route" autofocus>
                          <option value="">未選択</option>
                          @foreach ($routes as $route)
                            <option value="{{ $route->id }}" {{ $requestDetail->route == $route->id ? 'selected': '' }}>{{ $route->name }}</option>
                          @endforeach
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
