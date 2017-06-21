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
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('kana') ? ' has-error' : '' }}">
                    <th><label for="kana" class="col-lg-12 control-label">フリガナ</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="kana" type="text" class="form-control" name="kana" value="{{ old('kana', $client->kana.' '.$client->first_name_kana) }}" autofocus>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <th><label for="name" class="col-lg-12 control-label">名前</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $client->name.' '.$client->first_name) }}" autofocus>
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
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                    <th><label for="job" class="col-lg-12 control-label">職業</label></th>
                    <td>
                      <div class="col-lg-12">
                        @foreach ($jobs as $index => $job)
                          <input type="radio" name="job" value="{{ $index }}" {{ $client->job == $index ? 'checked': '' }}>{{ $job }}
                        @endforeach
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                    <th><label for="birthday" class="col-lg-12 control-label">生年月日</label></th>
                    <td>
                      <div class="col-lg-12">
                        <input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday', $client->birthday) }}">
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                    <th><label for="tel" class="col-lg-12 control-label">電話番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="tel" type="text" class="form-control" name="tel" value="{{ old('tel', $client->tel) }}">
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                    <th><label for="fax" class="col-lg-12 control-label">FAX番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="fax" type="text" class="form-control" name="fax" value="{{ old('fax', $client->fax) }}">
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                    <th><label for="postal_code" class="col-lg-12 control-label">郵便番号</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="postal_code" type="text" class="form-control postal_code" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}">
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('prefecture') ? ' has-error' : '' }}">
                    <th><label for="prefecture" class="col-lg-12 control-label">都道府県</label></th>
                    <td>
                      <div class="col-lg-12">
                        <select id="prefecture" class="form-control" name="prefecture" autofocus>
                          <option value="">未選択</option>
                          @foreach ($prefs as $index => $name)
                            <option value="{{ $index }}" {{ $client->prefecture == $index ? 'selected': '' }}>{{ $name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <th><label for="address" class="col-lg-12 control-label">住所</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="address" type="text" class="form-control" name="address" value="{{ old('address', $client->address) }}">
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group{{ $errors->has('mail') ? ' has-error' : '' }}">
                    <th><label for="mail" class="col-lg-12 control-label">メールアドレス</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="mail" type="email" class="form-control" name="mail" value="{{ old('mail', $client->mail) }}">
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
