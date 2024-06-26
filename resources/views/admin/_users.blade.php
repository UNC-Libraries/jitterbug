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
              <td class="admin"><input role="button" data-username="{{$record->username}}" type="checkbox" @if ($record->admin === 1) checked="checked" @endif @if ($record->inactive === 1 || \Auth::user()->id === $record->id) disabled="disabled" @endif></td>
              <td class="inactive"><input role="button" data-username="{{$record->username}}" type="checkbox" @if ($record->inactive === 1) checked="checked" @endif @if (\Auth::user()->id === $record->id) disabled="disabled" @endif></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <script>
      $(document).ready( function () {
        let table = $('#user-table').DataTable({
          columnDefs: [
            // the last two columns are not orderable: admin & inactive checkboxes
            { orderable: false, targets: [-2, -1] }
          ]
        });

        table.on('click', '.admin', function(e) {
          var makeAdmin = $(this).is(':checked');
          var route = makeAdmin ? '/admin/make-admin'
                  : '/admin/remove-admin';
          var data = {};
          var username = $(this).data('username');
          data['username'] = username;
          $.post(route, data, function (data) {
            var message = makeAdmin
                    ? 'User ' + username + ' was successfully made admin.'
                    : 'User ' + username + ' is no longer an admin.';
            $(window).scrollTop(0);
            jitterbug.displayAlert('success', message);
          })
                  .fail(function (jqXHR) {
                    // Validation error
                    if (jqXHR.status == 422) {
                      var errors = JSON.parse(jqXHR.responseText);
                      var errorMessage = errors['errors']['name'][0];
                      // Get the first error, no matter which it is.

                      // Unfortunately, we have to hide the popover here
                      // because it doesn't stay pinned to the field it
                      // relates to when the alert div is opened (a bug
                      // in Bootstrap/Tether).
                      jitterbug.displayAlert('danger', '<strong>Whoops.</strong> ' + errorMessage);
                    }
                  });
        });

        table.on('click', '.inactive', function(e) {
          jitterbug.toggleInactive();
        });
      });
    </script>
