<div class="panel-group" id="" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="" href="#summary_tab" aria-expanded="true" aria-controls="collapseOne">
           参考(見積時の数値)
        </a>
      </h4>
    </div>
    <div id="summary_tab" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <ul>
          <li>見込販売額：{{ nf_TP($item->expsell_min_price) }}円 ~ {{ nf_TP($item->expsell_max_price) }}円</li>
          <li>見込粗利額：{{ nf_TP($item->exp_min_profit) }}円 ~ {{ nf_TP($item->exp_max_profit) }}円</li>
          <li>見込粗利率：{{ chkRate($item->exp_min_profit_rate) }}% ~ {{ chkRate($item->exp_max_profit_rate) }}%</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="" href="#summary_memo_tab" aria-expanded="false" aria-controls="collapseTwo">
          商品メモ
        </a>
      </h4>
    </div>
    <div id="summary_memo_tab" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <textarea name="summary_memo_sub" rows="30" id="summary_memo_sub" class="memo" data-type="sub">{{ $item->memo }}</textarea>
      </div>
    </div>
  </div>
</div>
