<div id="data-container">
  <table id="data" class="table table-sm table-hover">
    <thead>
      <tr>
        <th width="12%">Call Number</th>
        <th width="13%">Date</th>
        <th width="17%">Engineer</th>
        <th width="15%">Vendor</th>
        <th width="20%">Collection</th>
        <th width="16%">Format</th>
        <th width="7%">Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($transfers as $transfer)
      <tr role="button" data-id="{{ $transfer->id }}" data-index="{{ $start + $index }}">
        <td>{{ $transfer->callNumber }}</td>
        <td>{{ $transfer->transferDate }}</td>
        <td title="{{ $transfer->engineerFirstName }} {{ $transfer->engineerLastName }}">{{ $transfer->engineerFirstName }} {{ $transfer->engineerLastName }}</td>
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
      {{ $transfers->total() }} {{$transfers->total()==1 ? "record" : "records"}} <span class="selection-count label label-default" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $transfers])
      </nav>
    </div>
  </div>
</div>