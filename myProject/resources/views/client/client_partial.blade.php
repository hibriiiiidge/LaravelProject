<div class="client_container">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="client_table">
                  <tr class="form-group{{ $errors->has('attribute') ? ' has-error' : '' }}">
                    <th><label for="attribute" class="col-lg-12 control-label">顧客属性</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input type="radio" name="attribute" value="1" {{ $client->attribute == 1 ? 'checked': '' }}>個人
                          <input type="radio" name="attribute" value="2" {{ $client->attribute == 2 ? 'checked': '' }}>法人
                          @if ($errors->has('attribute'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('attribute') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('base') ? ' has-error' : '' }}">
                    <th><label for="base" class="col-lg-12 control-label">担当拠点</label></th>
                    <td>
                      <div class="col-lg-12">
                          <select id="base" class="form-control" name="base" autofocus>
                            <option value=" ">未選択</option>
                            @foreach ($baseTypes as $baseType)
                              <option value="{{ $baseType->id }}" {{ $client->base == $baseType->id ? 'selected': '' }}>{{ $baseType->name }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('base'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('base') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('kana') ? ' has-error' : '' }}">
                    <th><label for="kana" class="col-lg-12 control-label">フリガナ</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="kana" type="text" class="form-control" name="kana" value="{{ old('kana', $client->kana.' '.$client->first_name_kana) }}" autofocus>
                          @if ($errors->has('kana'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('kana') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <th><label for="name" class="col-lg-12 control-label">名前</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $client->name.' '.$client->first_name) }}" autofocus>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                    <th><label for="gender" class="col-lg-12 control-label">性別</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input type="radio" name="gender" value="1" {{ $client->gender == 1 ? 'checked': '' }}>男性
                          <input type="radio" name="gender" value="2" {{ $client->gender == 2 ? 'checked': '' }}>女性
                          <input type="radio" name="gender" value="3" {{ $client->gender == 3 ? 'checked': '' }}>不明
                          @if ($errors->has('gender'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('gender') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                    <th><label for="job" class="col-lg-12 control-label">職業</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input type="radio" name="job" value="1" {{ $client->job == 1 ? 'checked': '' }}>会社員
                          <input type="radio" name="job" value="2" {{ $client->job == 2 ? 'checked': '' }}>会社役員
                          <input type="radio" name="job" value="3" {{ $client->job == 3 ? 'checked': '' }}>自営業
                          <input type="radio" name="job" value="4" {{ $client->job == 4 ? 'checked': '' }}>公務員
                          <input type="radio" name="job" value="5" {{ $client->job == 5 ? 'checked': '' }}>専業主婦
                          <input type="radio" name="job" value="6" {{ $client->job == 6 ? 'checked': '' }}>学生
                          <input type="radio" name="job" value="7" {{ $client->job == 7 ? 'checked': '' }}>フリーター
                          <input type="radio" name="job" value="8" {{ $client->job == 8 ? 'checked': '' }}>年金受給者
                          <input type="radio" name="job" value="9" {{ $client->job == 9 ? 'checked': '' }}>その他
                          @if ($errors->has('job'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('gender') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                    <th><label for="birthday" class="col-lg-12 control-label">生年月日</label></th>
                    <td>
                      <div class="col-lg-12">
                        <input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday', $client->birthday) }}">
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                        @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                    <th><label for="tel" class="col-lg-12 control-label">電話番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="tel" type="text" class="form-control" name="tel" value="{{ old('tel', $client->tel) }}">
                          @if ($errors->has('tel'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('tel') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                    <th><label for="fax" class="col-lg-12 control-label">FAX番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="fax" type="text" class="form-control" name="fax" value="{{ old('fax', $client->fax) }}">
                          @if ($errors->has('fax'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('fax') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                    <th><label for="postal_code" class="col-lg-12 control-label">郵便番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}">
                          @if ($errors->has('postal_code'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('postal_code') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('prefecture') ? ' has-error' : '' }}">
                    <th><label for="prefecture" class="col-lg-12 control-label">都道府県</label></th>
                    <td>
                      <div class="col-lg-12">
                          <select id="prefecture" class="form-control" name="prefecture" autofocus>
                              <option value="">未選択</option>
                              <option value="1" {{ $client->prefecture == 1 ? 'selected': '' }}>埼玉県</option>
                              <option value="2" {{ $client->prefecture == 2 ? 'selected': '' }}>東京都</option>
                          </select>
                          @if ($errors->has('prefecture'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('prefecture') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <th><label for="address" class="col-lg-12 control-label">住所</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="address" type="text" class="form-control" name="address" value="{{ old('address', $client->address) }}">
                          @if ($errors->has('address'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('address') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('mail') ? ' has-error' : '' }}">
                    <th><label for="mail" class="col-lg-12 control-label">メールアドレス</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="mail" type="email" class="form-control" name="mail" value="{{ old('mail', $client->mail) }}">
                          @if ($errors->has('mail'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('mail') }}</strong>
                              </span>
                          @endif
                      </div>
                    </td>
                  </tr>
                </table>

                <div>
                  <input type="hidden" name="status" value="◯">
                  <input type="hidden" name="rgster" value="{{ Auth::user()->id }}">
                  <input type="hidden" name="updter" value="{{ Auth::user()->id }}">
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
