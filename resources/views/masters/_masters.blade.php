<div id="data-container">
  <table id="data" class="table table-sm table-hover">
    <thead>
      <tr>
        <th width="12%">Call Number</th>
        <th width="20%">File Name</th>
        <th width="25%">Collection</th>
        <th width="21%">Format</th>
        <th width="15%">Department</th>
        <th width="7%">Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($masters as $master)
      <tr role="button" data-id="{{ $master->id }}" data-index="{{ $start + $index }}">
        <td>{{ $master->callNumber }}</td>
        <td>{{ $master->fileName }}</td>
        <td title="{{ $master->collectionName}}">{{ $master->collectionName }}</td>
        <td>{{ $master->formatName }}</td>
        <td>{{ $master->departmentName }}</td>
        <td>{{ $master->typeName }}</td>
      </tr>
      <?php $index++; ?>
      @endforeach                          
    </tbody>
  </table>
  <div class="data-footer">
    <div class="record-count">
      {{ $masters->total() }} {{$masters->total()==1 ? "record" : "records"}} <span class="selection-count label label-default" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $masters])
      </nav>
    </div>
  </div>
</div>