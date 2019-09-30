
    <div id="record-container">
      <div style="margin-top: .75rem;">
        <a id="new-record-button" class="btn btn-sm btn-secondary" href="#" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
      </div>
      <div id="table-container">
        <table style="margin-top: .5rem;" class="table table-sm table-hover">
          <thead>
            <tr>
              <th width="24%">Archival Identifier</th>
              <th width="51%">Name</th>
              <th width="20%">Collection Type</th>
              <th width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr>
              <td><span class="editable" data-id="{{ $record->id }}" data-field="archivalIdentifier" role="button">{{ $record->archivalIdentifier }}</span></td>
              <td><span class="editable" data-id="{{ $record->id }}" data-field="name" role="button">{{ $record->name }}</span></td>
              <td>
                <span class="editable" data-id="{{ $record->id }}" data-field="collectionTypeId" role="button">
                  {{ \Jitterbug\Models\CollectionType::formattedName($record->collectionType) }}
                </span>
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
      <form class="form-inline">
        <input type="text" name="archivalIdentifier" class="form-control form-control-sm" maxlength="255" placeholder="Archival Identifier" autocomplete="off" style="width: 150px;">
        <input type="text" name="name" class="form-control form-control-sm" maxlength="255" placeholder="Name" autocomplete="off" style="width: 250px;">
        {!! Form::select('collectionTypeId', $collectionTypes, null, array('class' => 'form-control form-control-sm')) !!}
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-new-record"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>

    <div id="edit-name-form" class="hidden">
      <form class="form-inline">
        <input type="text" name="name" class="form-control form-control-sm" maxlength="255" placeholder="Name" autocomplete="off" style="width: 250px;">
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>

    <div id="edit-collectionTypeId-form" class="hidden">
      <form class="form-inline">
        {!! Form::select('collectionTypeId', $collectionTypes, null, array('class' => 'form-control form-control-sm', 'data-field' => 'collectionTypeId')) !!}
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>

    <div id="edit-archivalIdentifier-form" class="hidden">
      <form class="form-inline">
        <input type="text" name="archivalIdentifier" class="form-control form-control-sm" maxlength="255" placeholder="Archival Identifier" autocomplete="off" style="width: 250px;">
        <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
        <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
      </form>
    </div>