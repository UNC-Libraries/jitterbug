<div id="record-container">
  <div style="margin-top: .75rem;">
    <a id="new-record-button" class="btn btn-sm btn-secondary" href="#" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
  </div>
  <div id="table-container">
    <table style="margin-top: .5rem;" class="table table-sm table-hover">
      <thead>
      <tr>
        <th width="8%">ID</th>
        <th width="15%">Label</th>
        <th width="50%">Collection Type</th>
        <th width="22%">Legacy</th>
        <th width="5%"></th>
      </tr>
      </thead>
      <tbody>
      @foreach ($records as $record)
        <tr>
          <td><span data-field="id">{{ $record->id }}</span></td>
          <td><span class="editable" data-id="{{ $record->id }}" data-field="label" role="button">{{ $record->label }}</span></td>
          <td>
            <span class="editable" data-id="{{ $record->id }}" data-field="collection_type_id" data-role="button">
              {{ \Jitterbug\Models\CollectionType::formattedName($record->collectionType) }}
            </span>
          </td>
          <td class="legacy"><input role="button" data-id="{{ $record->id }}" type="checkbox" @if ($record->legacy === 1) checked="checked" @endif></td>
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
    <input type="text" name="label" class="form-control form-control-sm" maxlength="255" placeholder="Label" autocomplete="off" style="width: 250px;">
    {{ html()->select('collection_type_id', $collectionTypes)->class('form-control form-control-sm') }}
    Legacy?
    <input role="button" type="checkbox">
    <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
    <button class="btn btn-sm btn-secondary cancel-new-record"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
  </form>
</div>

<div id="edit-label-form" class="hidden">
  <form class="form-inline">
    <input type="text" name="label" class="form-control form-control-sm" maxlength="255" placeholder="Label" autocomplete="off" style="width: 250px;">
    <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
    <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
  </form>
</div>

<div id="edit-collection_type_id-form" class="hidden">
  <form class="form-inline">
    {{ html()->select('collection_type_id', $collectionTypes)->class('form-control form-control-sm')->data('field', 'collection_type_id') }}
    <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
    <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
  </form>
</div>

<div id="edit-legacy-form" class="hidden">
  <form class="form-inline">
    <input type="text" name="legacy" class="form-control form-control-sm" maxlength="255" placeholder="Legacy?" autocomplete="off" style="width: 250px;">
    <button class="btn btn-sm btn-secondary popover-submit" type="submit"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
    <button class="btn btn-sm btn-secondary cancel-edit"><i class="fa fa-fw fa-ban" aria-hidden="true"></i></button>
  </form>
</div>
