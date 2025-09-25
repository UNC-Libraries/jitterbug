<div id="data-container">
  <table id="transfers-data" class="table table-sm table-hover" data-sort-column="{{$sortColumn}}" data-sort-direction="{{$sortDirection}}">
    <thead>
      <tr id="header-row">
        <th data-sort-direction="{{$sortColumn === 'callNumber' ? $sortDirection : 'asc'}}" data-sort-column="callNumber">
          Call Number&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th>Date</th>
        <th data-sort-direction="{{$sortColumn === 'engineerLastName' ? $sortDirection : 'asc'}}" data-sort-column="engineerLastName">
          Engineer&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th>Vendor</th>
        <th>Collection</th>
        <th>Format</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($transfers as $transfer)
      <tr role="button" class="@if ($marks->contains($transfer->id)) marked @endif" data-id="{{ $transfer->id }}" data-index="{{ $start + $index }}">
        <td>{{ $transfer->callNumber }}</td>
        <td>{{ $transfer->transferDate }}</td>
        <td @if ($transfer->engineerName) title="{{ $transfer->engineerFirstName }} {{ $transfer->engineerLastName }}" @endif>{{ $transfer->engineerFirstName }} {{ $transfer->engineerLastName }}</td>
        <td>{{ $transfer->vendorName }}</td>
        <td title="{{ $transfer->collectionName }}">{{ $transfer->collectionName }}</td>
        <td>{{ $transfer->formatName }}</td>
        <td>{{ $transfer->typeName }}</td>
      </tr>
      <?php $index++; ?>
      @endforeach                          
    </tbody>
  </table>
  <div class="data-footer">
    <div class="record-count">
      {{ $totalRecordCount }} <span class="selection-count bg bg-secondary" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $transfers])
      </nav>
    </div>
  </div>
</div>