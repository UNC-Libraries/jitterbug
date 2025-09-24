// import $ from 'jquery';
// window.$ = window.jQuery = $;
import DataTable from 'datatables.net-dt';
import {jitterbug} from './jitterbug';

export default $(document).ready( function () {
    new DataTable('#user-table', {
        columnDefs: [
            // the last two columns are not orderable: admin & inactive checkboxes
            { orderable: false, targets: [-2, -1] }
        ]
    });

    let table = $('#user-table');
    table.on('click', '.admin', function(e) {
        if (e.target.id.startsWith('admin')) {
            jitterbug.toggleAdmin(e.target.id);
        }
    });

    table.on('click', '.inactive', function(e) {
        if (e.target.id.startsWith('active')) {
            jitterbug.toggleInactive(e.target.id);
        }
    });
});