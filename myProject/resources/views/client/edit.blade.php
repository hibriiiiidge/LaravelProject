@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="">
  {{ csrf_field() }}
  <div class="">
      <button type="submit" class="btn btn-info" style="float:right;">
          検索
      </button>
  </div>
  <div class="">
    <input type="text" name="search" value="" width="100px" style="float:right;">
  </div>
  <div id="rgst_btn">
      <button type="submit" class="btn btn-primary">
          登録
      </button>
  </div>
  <div id="select_tab">
      <ul class="nav nav-tabs" style="margin-bottom: -1.5px;">
          <li class="active"><a href="#client_tab" data-toggle="tab">顧客</a></li>
          <li><a href="#request_tab" data-toggle="tab">依頼</a></li>
          <li><a href="#item_tab" data-toggle="tab">商品</a></li>
          <li><a href="#add_item_tab" data-toggle="tab">+追加</a></li>
      </ul>
  </div>
  <div id="wrap_main_container">
    <div id="myTabContent" class="tab-content" style="padding-top: 5px;border-top: 1px #eee solid;">
    <!--TAB CLIENT START-->
      <div class="tab-pane fade in active" id="client_tab">
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
                                        <option value="{{ $baseType->id }}" {{ $client->base == $baseType->id ? 'checked': '' }}>{{ $baseType->name }}</option>
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
                            <input type="hidden" name="updter" value="{{ Auth::user()->id }}">
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div><!--TAB client END-->
      <div class="tab-pane fade" id="request_tab">
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
      </div><!--TAB request END-->
      <div class="tab-pane fade" id="item_tab">
          <div class="item_container">
              <div id="" class="top_shops clearfix grid">
                <h1>商品</h1>
              </div>
          </div>
      </div><!--TAB item END-->
    </div><!-- TAB All END -->
  </div><!-- #wrap_main_container -->
  <div id="progress_container">
    <div class="progress_block">
      <label for="progress_status">進捗状況</label>
      <select id="progress_status" name="progress_status">
        <option value="1">要返信</option>
        <option value="2">見積済</option>
        <option value="3">交渉中</option>
        <option value="4">荷着待</option>
      </select>
      <textarea name="progress_memo" rows="3" placeholder="伝達事項" id="progress_memo"></textarea>
    </div>
    <div class="progress_table">
      <table class="table table-striped table-hover">
        <tbody>
          @foreach ($rProgresses as $rProgress)
            <tr>
              <th>
                {{ $rProgress->dt }}
              </th>
              <td>
                {{ $rProgress->status }}<br/>
                <span>{{ $rProgress->memo }}</span><br/>
                <span>{{ $rProgress->name }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div id="summary_container">
    <!-- ここからアコーディオン（Collapse） -->
    <div class="panel-group" id="" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="" href="#summary_tab" aria-expanded="true" aria-controls="collapseOne">
              サマリー
            </a>
          </h4>
        </div>
        <div id="summary_tab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <ul>
              <li>拠点：{{ $client->base }}</li>
              <li>名前：{{ $client->fullname }}</li>
              <li>電話番号:{{ $client->tel }}</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="" href="#summary_memo_tab" aria-expanded="false" aria-controls="collapseTwo">
              管理者メモ
            </a>
          </h4>
        </div>
        <div id="summary_memo_tab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body">
            <textarea name="summary_memo_sub" rows="8" id="summary_memo_sub" class="memo" data-type="sub">{{  old('summary_memo_sub', $requestDetail->summary_memo) }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="memo_type" value="">
</form>
<script type="text/javascript">
  $(function(){
    //summary_memoのmainとsubのどちらを最後に編集したかを判定し、hiddenに値を持たせる処理
    $('.memo').focusout(function(e){
      $("input[name='memo_type']").val($(this).data('type'));
    });
  });
</script>
@endsection
