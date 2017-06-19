<nav class="st-menu st-effect-search" id="menu-search">
	<div id="form_title">検索フォーム</div>
  <div id="form_container">
    <form action="{{ action('RequestsController@index') }}" class="form-horizontal" method="get">
        <div class="form-group">
            <label class="control-label col-lg-3">氏名</label>
            <div class="col-lg-9">
                <input type="text" name="name" class="form-control" value="{{ $name }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">カナ</label>
            <div class="col-lg-9">
                <input type="text" name="kana" class="form-control" value="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-info">送信</button>
            </div>
        </div>
    </form>
</div>

</nav>
