<table class="table table-striped table-bordered table-hover">
    <thead>
      <td></td>
      @foreach ($categories as $category)
        <td>{{ $category->name }}</td>
      @endforeach
    </thead>
    <tbody>
      @for ($i=0; $i <count($checks) ; $i++)
        <tr>
          <td>{{ $checks[$i]['name'] }}</td>
          @for ($j=0; $j <count($categories) ; $j++)
            <td><input type="checkbox" name="" val="{{ $checks[$i]['val'][$j] }}" {{ $checks[$i]['check'][$j] }}></td>
          @endfor
        </tr>
      @endfor
  </tbody>
</table>
