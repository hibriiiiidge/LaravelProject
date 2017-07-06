<div class="panel-group" id="" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="" href="#summary_tab" aria-expanded="true" aria-controls="collapseOne">
          サマリー
        </a>
      </h4>
    </div>
    <div id="summary_tab" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <ul>
          <li>都道府県：{{ $client->prefecture ? $prefs[$client->prefecture] : '-' }}</li>
          <li>カナ：{{ $client->fullkana }}</li>
          <li>名前：{{ $client->fullname }}</li>
          <li>TEL:{{ chkStr($client->tel) }}</li>
          <li>MAIL:{{ chkStr($client->mail) }}</li>
          <li>FAX:{{ chkStr($client->fax) }}</li>
          <li>緊急度:{{ $requestDetail->urgency ? $urgencys[$requestDetail->urgency] : '-'  }}</li>
          <li>買取方法:{{ $requestDetail->buy_way ? $buy_ways[$requestDetail->buy_way] : '-' }}</li>
          <li>連絡方法:{{ $requestDetail->contact_way ? $contact_ways[$requestDetail->contact_way] : '-' }}</li>
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
    <div id="summary_memo_tab" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <textarea name="summary_memo_sub" rows="30" id="summary_memo_sub" class="memo" data-type="sub">{{  old('summary_memo_sub', $requestDetail->summary_memo) }}</textarea>
      </div>
    </div>
  </div>
</div>
