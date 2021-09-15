var table = new myTable({
    table: '#jobsTable',
    checkBox: true,
    columnsToFilterData: [1, 2, 3, 4, 5, 6, 7],
});

$('body').on('change', 'input:checkbox', function() {
    $('#massDeleteBtn').attr('disabled', (table.checkedTableRow(true).length > 0 ? false : true));
    $('#massEditBtn').attr('disabled',
        (table.checkedTableRow(true).length > 0 && table.checkedTableRow(true).length < 51) ? false : true);
});

$('#massEditBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="job_id[]" value="' + tr[0].value + '">';
    });

    $('#massEditJobModalForm').append(html);

    $('#editMessage').html('You want to delete this ' + $('#massEditJobModalForm input').length +
        ' job' + ($('#massEditJobModalForm input').length == 2 ? '' : 's') + '.');

    $('#massEditJobModal').on('show.bs.modal', function(e) {
        $('#massEditJobModalEdit').click(function() {
            $('#massEditJobModalForm').submit();
        });
        $('#massEditJobModalCancel').click(function() {
            $('#massEditJobModalForm input').remove();
        });
    });
});

$('#massDeleteBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="job_id[]" value="' + tr[0].value + '">';
    });

    $('#massDeleteJobModalForm').append(html);

    $('#deleteMessage').html('You want to delete this ' + ($('#massDeleteJobModalForm input').length - 1) +
        ' job' + ($('#massDeleteJobModalForm input').length == 2 ? '' : 's') + '.');

    $('#massDeleteJobModal').on('show.bs.modal', function(e) {
        $('#massDeleteJobModalDelete').click(function() {
            $('#massDeleteJobModalForm').submit();
        });
        $('#massDeleteJobModalCancel').click(function() {
            $('#massDeleteJobModalForm input[name="job_id[]"]').remove();
        });
    });
});