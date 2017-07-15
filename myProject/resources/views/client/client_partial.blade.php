<div class="client_container">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="client_table">
                  <tr class="form-group">
                    <th><label for="attribute" class="col-lg-12 control-label">顧客属性</label></th>
                    <td>
                      <div class="col-lg-4" id="client_attribute">
                          <input type="radio" name="attribute" value="1" {{ $client->attribute == 1 ? 'checked': '' }}>個人
                          <input type="radio" name="attribute" value="2" {{ $client->attribute == 2 ? 'checked': '' }}>法人
                      </div>
                      @if ($client->id)
                        <div class="col-lg-1 col-lg-offset-5">
                          <button type="button" name="button" class="btn btn-success"><a href="{{ action('ClientsController@repeat', $client->id) }}" id="repeat_btn">リピート登録</a></button>
                        </div>
                      @endif
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="base" class="col-lg-12 control-label">担当拠点</label></th>
                    <td>
                      <div class="col-lg-4">
                          <select id="base" class="form-control" name="base" autofocus>
                            <option value="">未選択</option>
                            @foreach ($baseTypes as $baseType)
                              <option value="{{ $baseType->id }}" {{ $client->base == $baseType->id ? 'selected': '' }}>{{ $baseType->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="kana" class="col-lg-12 control-label">フリガナ</label></th>
                    <td>
                      <div class="col-lg-4">
                          @php
                            $clinet_name_kana = $client->kana ? $client->kana.' '.$client->first_name_kana : "";
                          @endphp
                          <input id="kana" type="text" class="form-control" name="kana" value="{{ old('kana', $clinet_name_kana) }}" placeholder="ex) ユーズド ネット">
                          <span class="guide">"セイ"と"ナ"の間に空白</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="name" class="col-lg-12 control-label">名前</label></th>
                    <td>
                      <div class="col-lg-4">
                          @php
                            $clinet_name = $client->name ? $client->name.' '.$client->first_name : "";
                          @endphp
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $clinet_name) }}"  placeholder="ex) 柚子度 熱人">
                          <span class="guide">姓と名の間に空白</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="gender" class="col-lg-12 control-label">性別</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input type="radio" name="gender" value="1" {{ $client->gender == 1 ? 'checked': '' }}>男性
                          <input type="radio" name="gender" value="2" {{ $client->gender == 2 ? 'checked': '' }}>女性
                          <input type="radio" name="gender" value="3" {{ $client->gender == 3 ? 'checked': '' }}>不明
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="job" class="col-lg-12 control-label">職業</label></th>
                    <td>
                      <div class="col-lg-12">
                        @foreach ($jobs as $index => $job)
                          <input type="radio" name="job" value="{{ $index }}" {{ $client->job == $index ? 'checked': '' }}>{{ $job }}
                        @endforeach
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="birthday" class="col-lg-12 control-label">生年月日</label></th>
                    <td>
                      <div class="col-lg-4">
                        <input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday', $client->birthday) }}" placeholder="ex) 20040401">
                        <span class="guide">半角</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="tel" class="col-lg-12 control-label">電話番号</label></th>
                    <td>
                      <div class="col-lg-5">
                          <input id="tel" type="text" class="form-control" name="tel" value="{{ old('tel', $client->tel) }}" placeholder="ex) 0493274302">
                          <span class="guide">半角 ハイフン不要</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="fax" class="col-lg-12 control-label">FAX番号</label></th>
                    <td>
                      <div class="col-lg-5">
                          <input id="fax" type="text" class="form-control" name="fax" value="{{ old('fax', $client->fax) }}" placeholder="ex) 0493252392">
                          <span class="guide">半角 ハイフン不要</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="postal_code" class="col-lg-12 control-label">郵便番号</label></th>
                    <td>
                      <div class="col-lg-4">
                          <input id="postal_code" type="text" class="form-control postal_code" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}" placeholder="ex) 3550076">
                          <span class="guide">半角 ハイフン不要</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="prefecture" class="col-lg-12 control-label">都道府県</label></th>
                    <td>
                      <div class="col-lg-4">
                        <select id="prefecture" class="form-control" name="prefecture" autofocus>
                          <option value="">未選択</option>
                          @foreach ($prefs as $index => $name)
                            <option value="{{ $index }}" {{ $client->prefecture == $index ? 'selected': '' }}>{{ $name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="address" class="col-lg-12 control-label">住所</label></th>
                    <td>
                      <div class="col-lg-12">
                          <input id="address" type="text" class="form-control" name="address" value="{{ old('address', $client->address) }}" placeholder="ex) 東松山市下唐子1437-4">
                          <span class="guide">マンション・アパート名 確認</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="form-group">
                    <th><label for="mail" class="col-lg-12 control-label">メールアドレス</label></th>
                    <td>
                      <div class="col-lg-8">
                          <input id="mail" type="email" class="form-control" name="mail" value="{{ old('mail', $client->mail) }}" placeholder="ex) info@usednet.co.jp">
                          <span class="guide">半角</span>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
