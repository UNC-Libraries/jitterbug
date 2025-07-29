    <div id="record-container">
      <div style="margin-top: .75rem;">
        <a id="new-record-button" class="btn btn-sm btn-secondary" href="#" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
      </div>
      <div id="table-container">
        <table style="margin-top: .5rem;" class="table table-sm table-hover">
          <thead>
            <tr>
              <th width="8%">ID</th>
              <th width="30%">Name</th>
              <th width="32%">Prefixes</th>
              <th width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr>
              <td><span data-field="id">{{ $record->id }}</td>
              <td><span class="editable" data-id="{{ $record->id }}" data-field="name" role="button">{{ $record->name }}</span></td>
              <td>
                <span data-field="prefixes">
                  @if ($record->uniquePrefixLabels() === []) Please add prefixes. @endif
                  @foreach ($record->uniquePrefixLabels() as $prefix)
                    {{$prefix}},
                  @endforeach
                </span>
                <a class="btn btn-sm btn-secondary pull-right" href="{{route('formats.show', ['formats' => $record->id])}}">Edit Prefixes</a>
              </td>
              <td><a href="#" role="button" class="delete" title="Delete record" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{--Need the surrounding div here to keep the form displaying inline--}}
    <div id="new-record-form" class="hidden">
      <form class="d-flex flex-row align-items-center flex-wrap">
        <input type="text" name="name" class="form-control form-control-sm" maxlength="255" placeholder="Name" autocomplete="off" style="width: 200px;">
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-new-record"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>

    <div id="edit-name-form" class="hidden">
      <form class="d-flex flex-row align-items-center flex-wrap">
        <input type="text" name="name" class="form-control form-control-sm" maxlength="255" placeholder="Name" autocomplete="off" style="width: 200px;">
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>

