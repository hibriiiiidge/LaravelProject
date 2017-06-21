<div class="form-group">
    <label for="rt_name" class="col-md-4 control-label">名称</label>
    <div class="col-md-6">
        <input id="rt_name" type="text" class="form-control" name="rt_name" value="{{ old('rt_name', $route->name) }}" required autofocus>
    </div>
</div>
<div class="form-group">
    <label for="rt_url" class="col-md-4 control-label">url</label>
    <div class="col-md-6">
        <input id="rt_url" type="text" class="form-control" name="rt_url" value="{{ old('rt_url', $route->url) }}"autofocus>
    </div>
</div>
<div class="form-group">
    <label for="rt_status" class="col-md-4 control-label">公開状況</label>
    <div class="col-md-6">
        <select id="rt_status" class="form-control" name="rt_status" required autofocus>
          <option value="◯" {{ $route->status ? ($route->status == '◯' ? 'selected':''): '' }}>公開中</option>
          <option value="X" {{ $route->status ? ($route->status == 'X' ? 'selected':''): '' }}>閉鎖</option>
        </select>
    </div>
</div>
