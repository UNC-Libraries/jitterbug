    <div id="record-container">
      <div id="table-container" style="height: 782px; overflow-y: scroll; margin-top: .25rem; margin-bottom: 1rem;">
        <table style="margin-top: .75rem;" class="table table-sm table-hover">
          <thead>
            <tr>
              <th width="7%">ID</th>
              <th width="20%">Username</th>
              <th width="20%">First Name</th>
              <th width="20%">Last Name</th>
              <th width="21%">Signed In</th>
              <th width="12%">Admin</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr data-id="{{$record->id}}">
              <td>{{ $record->id }}</td>
              <td>{{ $record->username }}</td>
              <td>{{ $record->firstName }}</td>
              <td>{{ $record->lastName }}</td>
              <td>{{ $record->updatedAt }}</td>
              <td><input role="button" data-username="{{$record->username}}" type="checkbox" @if ($record->admin === 1) checked="checked" @endif></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>