<div id="data-container">
  {{-- The ID of this table needs to be unique across Jitterbug (i.e. different than the data table in masters or transfers) so that the colResizable plugin stores and loads unique column widths (set by the user) to localStorage. --}}
  <table id="items-data" class="table table-sm table-hover" data-sort-column="{{$sortColumn}}" data-sort-direction="{{$sortDirection}}">
    <thead>
      <tr id="header-row" role="rowheader">
        {{-- data name is camelCase for solr query purposes, see SolariumProxy--}}
        <th data-sort-direction="{{$sortColumn === 'callNumber' ? $sortDirection : 'asc'}}" data-sort-column="callNumber">
          Call #&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th data-sort-direction="{{$sortColumn === 'title' ? $sortDirection : 'asc'}}" data-sort-column="title">
          Title&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th data-sort-direction="{{$sortColumn === 'containerNote' ? $sortDirection : 'asc'}}" data-sort-column="containerNote">
          Container Note&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th>Collection</th>
        <th>Format</th>
        <th>Type</th>
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
      {{ $totalRecordCount }} <span class="selection-count label label-default" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $items])
      </nav>
    </div>
  </div>
</div>