    <h6>{{Str::title($name)}} Filters <span id="{{Str::lower($name)}}-filters-selection-count" class="selection-count badge bg-secondary" style="margin-left: 5px;"></span></h6>
    <ul id="{{Str::lower($name)}}-filters" class="filter-list" style="{{$style ?? ''}}">
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