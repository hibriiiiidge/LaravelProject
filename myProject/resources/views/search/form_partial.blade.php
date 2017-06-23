<nav class="st-menu st-effect-search" id="menu-search">
	<div id="form_title">検索フォーム</div>
  <div id="form_container">
    <form action="{{ action('RequestsController@index') }}" class="form-horizontal" method="get">
				<div class="form-group">
						<label class="control-label col-lg-3">依頼ID</label>
						<div class="s_input_wrap col-lg-9">
								<input type="text" id="s_reqdtl_id" name="reqdtl_id" class="s_input form-control" value="">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">顧客ID</label>
						<div class="s_input_wrap col-lg-9">
								<input type="text" id="s_clt_id" name="clt_id" class="s_input form-control" value="">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">カナ</label>
						<div class="s_input_wrap col-lg-9">
								<input type="text" id="s_kana" name="kana" class="s_input form-control" value="{{ $kana }}">
						</div>
				</div>
				<div class="form-group">
            <label class="control-label col-lg-3">氏名</label>
            <div class="s_input_wrap col-lg-9">
                <input type="text" id="s_name" name="name" class="s_input form-control" value="{{ $name }}">
            </div>
        </div>
				<div class="form-group">
						<label class="control-label col-lg-3">TEL</label>
						<div class="s_input_wrap col-lg-9">
								<input type="tel" id="s_tel" name="tel" class="s_input form-control" value="">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">FAX</label>
						<div class="s_input_wrap col-lg-9">
								<input type="tel" id="s_fax" name="fax" class="s_input form-control" value="">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">緊急度</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_urgency" name="urgency" class="s_select form-control">
										<option value="0"></option>
									@foreach ($urgencys as $index => $urgency)
										<option value="{{ $index }}">{{ $urgency }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">拠点</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_base" name="base" class="s_select form-control">
									<option value="0"></option>
									@foreach ($base_types as $base_type)
										<option value="{{ $base_type->id }}">{{ $base_type->name }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">進捗状況</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_status" name="status" class="s_select form-control">
									<option value="0"></option>
									@foreach ($prges as $index => $prge)
										<option value="{{ $index }}">{{ $prge }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">買取方法</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_buy_way" name="buy_way" class="s_select form-control">
									<option value="0"></option>
									@foreach ($buy_ways as $index => $buy_way)
										<option value="{{ $index }}">{{ $buy_way }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">都道府県</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_prefecture" name="prefecture" class="s_select form-control">
									<option value="0"></option>
									@foreach ($prefs as $index => $pref)
										<option value="{{ $index }}">{{ $pref }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">受付担当</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_staff" name="staff" class="s_select form-control">
									<option value="0"></option>
									@foreach ($staffs as $staff)
										<option value="{{ $staff->id }}">{{ $staff->name }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">受付日</label>
						<div class="input-daterange input-group col-lg-9">
						    <input type="text" id="s_rgst_from" class="input-sm input_dt form-control" name="rgst_from">
						    <span class="input-group-addon">〜</span>
						    <input type="text" id="s_rgst_to" class="input-sm input_dt form-control" name="rgst_to">
						</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">最確日</label>
					<div class="input-daterange input-group col-lg-9">
					    <input type="text" id="s_fin_from" class="input-sm input_dt form-control" name="fin_from">
					    <span class="input-group-addon">〜</span>
					    <input type="text" id="s_fin_to" class="input-sm input_dt form-control" name="fin_to">
					</div>
				</div>
        <div class="form-group">
            <div class="col-xs-offset-8 col-xs-4">
                <button type="submit" class="btn btn-info">検索</button>
            </div>
        </div>
    </form>
</div>
</nav>
