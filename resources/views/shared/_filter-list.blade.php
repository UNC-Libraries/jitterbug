    <h6>{{Str::title($name)}} Filters</h6>
    <ul id="{{Str::lower($name)}}-filters" class="filter-list" style="{{$style or ''}}">
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="0">
            Any
          </label>

        </div>
      </li>
      @foreach ($filters as $filter)
      <li>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="{{ $filter->id }}">
            {{ $filter->name }}&nbsp;<span class="filter-count">({{ $filter->count }})</span>
          </label>
        </div>
      </li>
      @endforeach
    </ul>