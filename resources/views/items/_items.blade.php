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
      <?php $index = 0; ?>
      @foreach ($items as $item)
      <tr role="button" data-id="{{ $item->id }}" data-index="{{ $start + $index }}">
        <td>{{ $item->callNumber }}</td>
        <td title="{{ $item->title }}">{{ $item->title }}</td>
        <td title="{{ $item->containerNote }}">{{ $item->containerNote }}</td>
        <td title="{{ $item->collectionName }}">{{ $item->collectionName }}</td>
        <td>{{ $item->formatName }}</td>
        <td>{{ $item->typeName }}</td>
      </tr>
      <?php $index++; ?>
      @endforeach                          
    </tbody>
  </table>
  <div class="data-footer">
    <div class="record-count">
      {{ $items->total() }} {{$items->total()==1 ? "record" : "records"}} <span class="selection-count" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._ajax-pagination', ['paginator' => $items])
      </nav>
    </div>
  </div>
</div>