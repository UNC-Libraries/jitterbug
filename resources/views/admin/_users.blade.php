<div id="record-container">
  <div id="table-container">
    <table id="user-table" style="margin-top: .75rem;" class="table table-sm table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Signed In</th>
        <th>Admin</th>
        <th>Inactive</th>
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
          <td class="admin">
            <input id="admin-{{$record->username}}" data-username="{{$record->username}}" type="checkbox" aria-label="Admin" @if ($record->admin === 1) checked="checked" @endif @if ($record->inactive === 1 || \Auth::user()->id === $record->id) disabled="disabled" @endif>
          </td>
          <td class="inactive">
            <input id="active-{{$record->username}}" data-username="{{$record->username}}" type="checkbox" aria-label="Inactive" @if ($record->inactive === 1) checked="checked" @endif @if (\Auth::user()->id === $record->id) disabled="disabled" @endif>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@vite('resources/assets/js/usersTable.js')