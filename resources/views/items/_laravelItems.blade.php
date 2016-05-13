<div id="data-container">
  <table id="data" class="table table-sm table-hover">
    <thead>
      <tr>
        <th width="12%">Call Number</th>
        <th width="20%">Title</th>
        <th width="30%">Container Note</th>
        <th width="15%">Collection</th>
        <th width="16%">Format</th>
        <th width="7%">Type</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $item)
      <tr role="button">
        <td>{{ $item->callNumber }}</td>
        <td title="{{ $item->title }}">{{ $item->title }}</td>
        <td title="{{ $item->containerNote }}">{{ $item->containerNote }}</td>
        <td title="{{ $item->collection->name }}">{{ $item->collection->name }}</td>
        <td>{{ $item->format->name }}</td>
        <td>{{ $item->type }}</td>
      </tr>
      @endforeach                          
    </tbody>
  </table>
  <div class="data-footer">
    <div class="record-count">
      {{ $items->total() }} records
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $items])
      </nav>
    </div>
  </div>
</div>