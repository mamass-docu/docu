var types = {
    ICT: [0, 1, 2, 3, 5, 6, 18, 19, 20],
    Computer_Set: [0, 1, 2, 3, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
    All: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
};

var table = new myTable({
    table: '#assetsTable',
    checkBox: true,
    filterByType: '#assetsTable_type',
    filterByDate: true,
    columnsToFilterDate: { start: [19], end: [19] },
    columnsToShowForFilteredType: {
        ICT: types['ICT'],
        Computer_Set: types['Computer_Set'],
    },
});

$('body').on('change', 'input:checkbox', function() {
    $('#massDeleteBtn').attr('disabled', (table.checkedTableRow(true).length > 0 ? false : true));
    $('#massEditBtn').attr('disabled',
        (table.checkedTableRow(true).length > 0 && table.checkedTableRow(true).length < 51) ? false : true);
});

$('#massEditBtn').click(function() {
    var type = $('#assetsTable_type :selected').text(),
        html = '<input type="hidden" name="type" value="' + type + '">';

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        if (type == 'All' || tr[4] == type)
            html += '<input type="hidden" name="asset_id[]" value="' + tr[0].value + '">';
    });

    $('#massEditAssetModalForm').append(html);

    $('#editMessage').html('You want to edit this ' + ($('#massEditAssetModalForm input').length - 1) +
        ' asset' + ($('#massEditAssetModalForm input').length == 2 ? '' : 's') + '.');

    $('#massEditAssetModal').on('show.bs.modal', function(e) {
        $('#massEditAssetModalEdit').click(function() {
            $('#massEditAssetModalForm').submit();
        });
        $('#massEditAssetModalCancel').click(function() {
            $('#massEditAssetModalForm input').remove();
        });
    });

});

$('#massDeleteBtn').click(function() {
    var html = '';

    $('#deleteMessage').html('You want to delete this ' + table.checkedTableRow(true).length +
        ' asset' + (table.checkedTableRow(true).length == 1 ? '' : 's') + '.');

    table.eachTableCell(table.checkedTableRow(true), function(tr) {
        html += '<input type="hidden" name="asset_id[]" value="' + tr[0].value + '">';
    });

    $('#massDeleteAssetModalForm').append(html);

    $('#massDeleteAssetModal').on('show.bs.modal', function(e) {
        $('#massDeleteAssetModalDelete').click(function() {
            $('#massDeleteAssetModalForm').submit();
        });
        $('#massDeleteAssetModalCancel').click(function() {
            $('#massDeleteAssetModalForm input[name="asset_id[]"]').remove();
        });
    });
});