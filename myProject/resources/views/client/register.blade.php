@extends('layouts.app')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ action('ClientsController@store') }}">
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
                          <table class="table table-striped table-hover">
                            <tr class="form-group{{ $errors->has('attribute') ? ' has-error' : '' }}">
                              <th><label for="attribute" class="col-lg-12 control-label">顧客属性</label></th>
                              <td>
                                <div class="col-lg-12">
                                    <input type="radio" name="attribute" value="1">個人
                                    <input type="radio" name="attribute" value="2">法人
                                    <input type="radio" name="attribute" value="3">不明
                                    <input type="radio" name="attribute" value="4">個人リピーター
                                    <input type="radio" name="attribute" value="5">法人リピーター
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
                                        <option value="{{ $baseType->id }}">{{ $baseType->name }}</option>
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
                                    <input id="kana" type="text" class="form-control" name="kana" value="{{ old('kana') }}" autofocus>
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
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
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
                                    <input type="radio" name="gender" value="1">男性
                                    <input type="radio" name="gender" value="2">女性
                                    <input type="radio" name="gender" value="3">不明
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
                                    <input type="radio" name="job" value="1">会社員
                                    <input type="radio" name="job" value="2">会社役員
                                    <input type="radio" name="job" value="3">自営業
                                    <input type="radio" name="job" value="4">公務員
                                    <input type="radio" name="job" value="5">専業主婦
                                    <input type="radio" name="job" value="6">学生
                                    <input type="radio" name="job" value="7">フリーター
                                    <input type="radio" name="job" value="8">年金受給者
                                    <input type="radio" name="job" value="9">その他
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
                                  <input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday') }}">
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
                                    <input id="tel" type="text" class="form-control" name="tel" value="{{ old('tel') }}">
                                    @if ($errors->has('tel'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('tel') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              </td>
                            </tr>
                            <tr class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                              <th><label for="postal_code" class="col-lg-12 control-label">郵便番号</label></th>
                              <td>
                                <div class="col-lg-12">
                                    <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">
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
                                        <option value="1">埼玉県</option>
                                        <option value="2">東京都</option>
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
                                    <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}">
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
                                    <input id="mail" type="email" class="form-control" name="mail" value="{{ old('mail') }}">
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
      </div><!--TAB client END-->
      <div class="tab-pane fade" id="request_tab">
          <div class="request_container">
              <div id="" class="top_shops clearfix grid">
                <h1>買取情報</h1>
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
      <label for="">進捗状況</label>
      <select class="" name="">
        <option value="">要返信</option>
        <option value="">見積済</option>
        <option value="">交渉中</option>
      </select>
      <textarea name="" rows="3" placeholder="伝達事項" id="progress_memo"></textarea>
    </div>
    <div class="progress_table">
      <table class="table table-striped table-hover">
        <tbody>
          <tr>
            <th>
              6月7日(水)<br/>
              <span>11:30</span>
            </th>
            <td>
              交渉中<br/>
              <span>家族で相談して決めるとのこと。詳細は不明。</span><br/>
              <span>高橋</span>
            </td>
          </tr>
          <tr>
            <th>
              6月6日(火)<br/>
              <span>10:30</span>
            </th>
            <td>
              見積済<br/>
              <span>メールのみ</span><br/>
              <span>高橋</span>
            </td>
          </tr>
          <tr>
            <th>
              6月5日(月)<br/>
              <span>10:10</span>
            </th>
            <td>
              要返信<br/>
              <span>無し</span><br/>
              <span>高橋</span>
            </td>
          </tr>
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
              <li>拠点：東京</li>
              <li>性別：男性</li>
              <li>電話番号:09011112222</li>
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
            <textarea name="" rows="8" id="summary_memo"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
