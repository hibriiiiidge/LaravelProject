<div class="form-group">
    <label for="ic_name" class="col-md-4 control-label">名称</label>
    <div class="col-md-6">
        <input id="ic_name" type="text" class="form-control" name="ic_name" value="{{ old('ic_name', $item_category->name) }}" required autofocus>
    </div>
</div>
<div class="form-group">
    <label for="ic_status" class="col-md-4 control-label">使用状況</label>
    <div class="col-md-6">
        <select id="ic_status" class="form-control" name="ic_status" required autofocus>
          <option value="◯" {{ $item_category->status ? ($item_category->status == '◯' ? 'selected':''): '' }}>使用中</option>
          <option value="X" {{ $item_category->status ? ($item_category->status == 'X' ? 'selected':''): '' }}>中止</option>
        </select>
    </div>
</div>
