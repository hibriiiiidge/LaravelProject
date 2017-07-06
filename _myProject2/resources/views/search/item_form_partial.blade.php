<nav class="st-menu st-effect-search" id="menu-search">
	<div id="form_title">検索フォーム</div>
  <div id="item_form" class="form_container">
    <form action="" class="form-horizontal" method="get">
				<div class="form-group">
						<label class="control-label col-lg-3">商品ID</label>
						<div class="col-lg-9">
							<div class="s_input_wrap item_id_wrap col-lg-5">
									<input type="text" id="" name="item_id_1" class="s_input s_input_short form-control" value="">
							</div>
							<div class="col-lg-1 item_id_wrap item_id_bar">
								<span>-</span>
							</div>
							<div class="s_input_wrap col-lg-2 item_id_wrap">
									<input type="text" id="" name="item_id_2" class="s_input s_input_short form-control" value="">
							</div>
							<div class="col-lg-1 item_id_wrap item_id_bar">
								<span>-</span>
							</div>
							<div class="s_input_wrap col-lg-3 item_id_wrap">
									<input type="text" id="" name="item_id_3" class="s_input s_input_short form-control" value="">
							</div>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">依頼ID</label>
						<div class="s_input_wrap col-lg-9">
								<input type="text" id="" name="request_id" class="s_input form-control" value="{{ $old_request_id }}">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">商品名</label>
						<div class="s_input_wrap col-lg-9">
								<input type="text" id="" name="item_name" class="s_input form-control" value="{{ $old_item_name }}">
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">進捗</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_progress" name="progress" class="s_select form-control">
										<option value="0"></option>
									@foreach ($i_prges as $index => $i_prge)
										<option value="{{ $index }}" {{ $old_progress == $index ? 'selected': '' }}>{{ $i_prge }}</option>
									@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3" style="font-size:10px;">カテゴリー</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_category" name="category_no" class="s_select form-control">
										<option value="0"></option>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}" {{ $old_category == $category->id ? 'selected': '' }}>{{ $category->name }}</option>
										@endforeach
								</select>
						</div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3">メーカー</label>
						<div class="s_input_wrap col-lg-9">
								<select id="s_maker" name="maker_no" class="s_select form-control">
										<option value="0"></option>
									@foreach ($makers as $maker)
										<option value="{{ $maker->id }}" {{ $old_maker == $maker->id ? 'selected': '' }}>{{ $maker->name }}</option>
									@endforeach
								</select>
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
