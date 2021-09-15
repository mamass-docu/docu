var table = new myTable({
    table: '#usersTable',
    checkBox: true,
    columnsToFilterData: [1, 2, 3],
});

$('body').on('change', 'input:checkbox', function() {
    $('#massDeleteBtn').attr('disabled', (table.checkedTableRow(true).length > 0 ? false : true));
    $('#massEditBtn').attr('disabled',
        (table.checkedTableRow(true).length > 0 && table.checkedTableRow(true).length < 51) ? false : true);
});

$('#massEditBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="user_id[]" value="' + tr[0].value + '">';
    });

    $('#massEditUserModalForm').append(html);

    $('#editMessage').html('You want to delete this ' + $('#massEditUserModalForm input').length +
        ' user' + ($('#massEditUserModalForm input').length == 2 ? '' : 's') + '.');

    $('#massEditUserModal').on('show.bs.modal', function(e) {
        $('#massEditUserModalEdit').click(function() {
            $('#massEditUserModalForm').submit();
        });
        $('#massEditUserModalCancel').click(function() {
            $('#massEditUserModalForm input').remove();
        });
    });
});

$('#massDeleteBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="user_id[]" value="' + tr[0].value + '">';
    });

    $('#massDeleteUserModalForm').append(html);

    $('#deleteMessage').html('You want to delete this ' + ($('#massDeleteUserModalForm input').length - 1) +
        ' user' + ($('#massDeleteUserModalForm input').length == 2 ? '' : 's') + '.');

    $('#massDeleteUserModal').on('show.bs.modal', function(e) {
        $('#massDeleteUserModalDelete').click(function() {
            $('#massDeleteUserModalForm').submit();
        });
        $('#massDeleteUserModalCancel').click(function() {
            $('#massDeleteUserModalForm input[name="user_id[]"]').remove();
        });
    });
});