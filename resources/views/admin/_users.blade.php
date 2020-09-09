    <div id="record-container">
      <div id="table-container">
        <table style="margin-top: .75rem;" class="table table-sm table-hover">
          <thead>
            <tr>
              <th class="max-content">ID</th>
              <th>Username</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Signed In</th>
              <th class="max-content">Admin</th>
              <th class="max-content">Inactive</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr data-id="{{$record->id}}" @if ($record->inactive ===1) class="inactive-row" @endif>
              <td>{{ $record->id }}</td>
              <td>{{ $record->username }}</td>
              <td>{{ $record->first_name }}</td>
              <td>{{ $record->last_name }}</td>
              <td>{{ $record->updated_at }}</td>
              <td class="admin"><input role="button" data-username="{{$record->username}}" type="checkbox" @if ($record->admin === 1) checked="checked" @if ($record->inactive === 1 || \Auth::user()->id === $record->id) disabled="disabled" @endif @endif></td>
              <td class="inactive"><input role="button" data-username="{{$record->username}}" type="checkbox" @if ($record->inactive === 1) checked="checked" @if (\Auth::user()->id === $record->id) disabled="disabled" @endif @endif></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>