<div id="data-container">
  <table id="instances-data" class="table table-sm table-hover" data-sort-column="{{$sortColumn}}" data-sort-direction="{{$sortDirection}}">
    <thead>
      <tr id="header-row">
        <th data-sort-direction="{{$sortColumn === 'callNumber' ? $sortDirection : 'asc'}}" data-sort-column="callNumber">
          Call Number&nbsp;<span class="fa fa-sort"></span>
        </th>
        <th>File Name</th>
        <th>Collection</th>
        <th>Format</th>
        <th>Department</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 0; ?>
      @foreach ($instances as $instance)
      <tr role="button" class="@if ($marks->contains($instance->id)) marked @endif" data-id="{{ $instance->id }}" data-index="{{ $start + $index }}">
        <td>{{ $instance->callNumber }}</td>
        <td>{{ $instance->fileName }}</td>
        <td title="{{ $instance->collectionName}}">{{ $instance->collectionName }}</td>
        <td>{{ $instance->formatName }}</td>
        <td>{{ $instance->departmentName }}</td>
        <td>{{ $instance->typeName }}</td>
      </tr>
      <?php $index++; ?>
      @endforeach                          
    </tbody>
  </table>
  <div class="data-footer">
    <div class="record-count">
      {{ $totalRecordCount}} <span class="selection-count badge bg-secondary" style="margin-left: 5px;"></span>
    </div>
    <div style="float: right;">
      <nav>
        @include('shared._pagination', ['paginator' => $instances])
      </nav>
    </div>
  </div>
</div>