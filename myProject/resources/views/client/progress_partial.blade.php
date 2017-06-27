<div class="progress_block">
  <label for="progress_status">進捗状況</label>
  <select id="progress_status" name="progress_status">
    @foreach ($prges as $index => $prg)
      <option value="{{ $index }}" {{ $latestSts == $index ? 'selected' : '' }}>{{ $prg }}</option>
    @endforeach
  </select>
  <textarea name="progress_memo" rows="3" placeholder="伝達事項" id="progress_memo"></textarea>
</div>
