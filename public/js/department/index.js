var table = new myTable({
    table: '#departmentsTable',
    checkBox: true,
    columnsToFilterData: [1, 2],
});

$('body').on('change', 'input:checkbox', function() {
    $('#massDeleteBtn').attr('disabled', (table.checkedTableRow(true).length > 0 ? false : true));
    $('#massEditBtn').attr('disabled',
        (table.checkedTableRow(true).length > 0 && table.checkedTableRow(true).length < 51) ? false : true);
});

$('#massEditBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="department_id[]" value="' + tr[0].value + '">';
    });

    $('#massEditDepartmentModalForm').append(html);

    $('#editMessage').html('You want to delete this ' + $('#massEditDepartmentModalForm input').length +
        ' department' + ($('#massEditDepartmentModalForm input').length == 2 ? '' : 's') + '.');

    $('#massEditDepartmentModal').on('show.bs.modal', function(e) {
        $('#massEditDepartmentModalEdit').click(function() {
            $('#massEditDepartmentModalForm').submit();
        });
        $('#massEditDepartmentModalCancel').click(function() {
            $('#massEditDepartmentModalForm input').remove();
        });
    });
});

$('#massDeleteBtn').click(function() {
    var html = '';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="department_id[]" value="' + tr[0].value + '">';
    });

    $('#massDeleteDepartmentModalForm').append(html);

    $('#deleteMessage').html('You want to delete this ' + ($('#massDeleteDepartmentModalForm input').length - 1) +
        ' department' + ($('#massDeleteDepartmentModalForm input').length == 2 ? '' : 's') + '.');

    $('#massDeleteDepartmentModal').on('show.bs.modal', function(e) {
        $('#massDeleteDepartmentModalDelete').click(function() {
            $('#massDeleteDepartmentModalForm').submit();
        });
        $('#massDeleteDepartmentModalCancel').click(function() {
            $('#massDeleteDepartmentModalForm input[name="department_id[]"]').remove();
        });
    });
});