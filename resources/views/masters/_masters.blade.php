<div id="data-container">
  <table id="masters-data" class="table table-sm table-hover">
    <thead>
      <tr id="header-row">
        <th data-sort="{{$sortColumn === 'callNumber' ? $sortDirection : 'asc'}}" data-name="callNumber">
          Call Number&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th data-sort="{{$sortColumn === 'fileName' ? $sortDirection : 'asc'}}" data-name="fileName">File Name#&nbsp;<span class="fa fa-sort"></span></th>
        <th>Collection</th>
        <th>Format</th>
        <th>Department</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($masters as $master)
      <tr role="button" class="@if ($marks->contains($master->id)) marked @endif" data-id="{{ $master->id }}" data-index="{{ $start + $index }}">
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