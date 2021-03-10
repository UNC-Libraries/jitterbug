<div id="data-container">
  {{-- The ID of this table needs to be unique across Jitterbug (i.e. different than the data table in masters or transfers) so that the colResizable plugin stores and loads unique column widths (set by the user) to localStorage. --}}
  <table id="items-data" class="table table-sm table-hover">
    <thead>
      <tr id="header-row" role="rowheader">
        <th data-sort="asc" data-name="call_number" width="12%">Call Number</th>
        <th data-sort="asc" data-name="title" width="20%">Title</th>
        <th data-sort="asc" data-name="container_note" width="30%">Container Note</th>
        <th width="15%">Collection</th>
        <th width="16%">Format</th>
        <th width="7%">Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($items as $item)
      <tr role="button" class="@if ($marks->contains($item->id)) marked @endif" data-id="{{ $item->id }}" data-index="{{ $start + $index }}">
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
      {{ $items->total() }} {{$items->total()==1 ? "record" : "records"}} <span class="selection-count label label-default" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $items])
      </nav>
    </div>
  </div>
</div>