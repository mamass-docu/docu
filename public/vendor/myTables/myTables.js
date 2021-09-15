class myTable {
    constructor(data) {
        this.table = data.table;
        this.checkBox = data.checkBox;
        this.columnsToFilterData = data.columnsToFilterData;
        this.columnsToShowForFilteredType = data.columnsToShowForFilteredType;
        this.filterByType = data.filterByType;
        this.disableSearch = data.disableSearch;
        this.disableLimit = data.disableLimit;
        this.disableSelectAll = data.disableSelectAll;
        this.disableSelectedCount = data.disableSelectedCount;
        this.disablePagination = data.disablePagination;
        this.filterByDate = data.filterByDate;
        this.columnsToFilterDate = data.columnsToFilterDate;

        this.allTableData = [];
        this.tableHeadings;

        this.init();
    }

    init() {
        var myTable = this,
            page = 1,
            pages = 1,
            limit = myTable.disableLimit ? myTable.allTableData.length : 10,
            dataToSearch = '',
            thead = [],
            rowNumber = [],
            filterType = 'All',
            filterTypeValue = 'All',
            startDate,
            endDate;

        $(myTable.table + ' tbody tr').each(function(i) {
            myTable.allTableData[i] = $(this);
        });

        var hold = [];
        $(myTable.table + ' thead th').each(function(i) {
            thead[i] = i;
            hold[i] = $(this);
        });

        this.tableHeadings = hold;

        appendTableBottomDiv();
        appendTableTopDiv();
        setTableData();

        $('#' + tableAsPrefix() + '_dataLimit').on('change', 'select', function() {
            limit = parseInt($('#' + tableAsPrefix() + '_dataLimit select :selected').text());

            setTableData();
        });

        $('#' + tableAsPrefix() + '_filterData').on('keyup', 'input', function() {
            dataToSearch = $('#' + tableAsPrefix() + '_filterData input').val().toUpperCase();

            setTableData();
        });

        $('#' + tableAsPrefix() + '_pagination').on('click', 'button', function() {
            var clickedPage = $(this).text();

            page = clickedPage == 'Next' ?
                (page == pages ? 1 : page + 1) :
                (clickedPage == 'Previous' ?
                    (page == 1 ? pages : page - 1) :
                    parseInt(clickedPage));

            setTableData();
        });

        if (myTable.checkBox) {
            $(myTable.table + ' tbody').on('change', 'input:checkbox', function() {
                updateCheckBoxValue();
            });
            $(myTable.table + ' thead').on('change', 'input:checkbox', function(cbox) {
                var cboxValue = $(this).is(':checked');

                $(myTable.table + ' tbody input:checkbox').each(function(i) {
                    $(this).prop('checked', cboxValue);
                });

                updateCheckBoxValue();
            });

            $(myTable.table + '_selectAll').on('change', 'input:checkbox', function() {
                var cboxValue = $(this).is(':checked');

                $(myTable.table + ' input:checkbox').each(function(i) {
                    $(this).prop('checked', cboxValue);
                });

                $.each(myTable.allTableData, function(a, tr) {
                    tr.children()[0].childNodes[0].checked = cboxValue;
                });

                $('#' + tableAsPrefix() + '_selectedCount').text(myTable.checkedTableRow(true).length + ' selected data.');
            });
        }

        if (myTable.filterByType) {
            $(myTable.filterByType).on('change', function() {
                filterTypeValue = $(myTable.filterByType + ' :selected').text();
                filterType = filterTypeValue.replace(/ /gi, '_');

                setTableData();
            });
        }

        if (myTable.filterByDate) {
            $('#' + tableAsPrefix() + '_filterDate').on('change', 'input', function() {
                if ($(this).attr('name') == 'start')
                    startDate = new Date($(this).val());
                else
                    endDate = new Date($(this).val());

                setTableData();
            });
            $('#' + tableAsPrefix() + '_filterDate').on('click', 'button', function() {
                if ($(this).attr('name') == 'resetStart') {
                    $('#' + tableAsPrefix() + '_filterDate input[name="start"]').val(null);
                    startDate = null;
                } else {
                    $('#' + tableAsPrefix() + '_filterDate input[name="end"]').val(null);
                    endDate = null;
                }

                setTableData();
            });
        }


        function setCboxAllValue() {
            $(myTable.table + ' thead input:checkbox').prop('checked', false);
            $(myTable.table + '_selectAll input:checkbox').prop('checked', false);

            if (myTable.checkedTableRow().length == $(myTable.table + ' tbody tr').length && pages != 0)
                $(myTable.table + ' thead input:checkbox').prop('checked', true);

            if (myTable.checkedTableRow(true).length == myTable.allTableData.length)
                $(myTable.table + '_selectAll input:checkbox').prop('checked', true);
        }

        function updateCheckBoxValue() {
            $(myTable.table + ' tbody input:checkbox').each(function(i, cbox) {
                $.each(rowNumber, function(b, row) {
                    if (i == b)
                        myTable.allTableData[row].children()[0].childNodes[0].checked = cbox.checked;
                });
            });

            $('#' + tableAsPrefix() + '_selectedCount').text(myTable.checkedTableRow(true).length + ' selected data.');

            setCboxAllValue();
        }

        function setTableData() {
            var columns = myTable.columnsToFilterData ? myTable.columnsToFilterData : thead,
                tbody = myTable.allTableData,
                start = thead,
                end = thead,
                holdRowNum = [];

            rowNumber = [];

            if (myTable.columnsToFilterDate) {
                start = myTable.columnsToFilterDate.start ? myTable.columnsToFilterDate.start : thead;
                end = myTable.columnsToFilterDate.end ? myTable.columnsToFilterDate.end : thead
            }

            if (!myTable.disableSearch)
                tbody = $.grep(myTable.allTableData, function(tr, d) {
                    var filteringPassed = false,
                        filterTypePassed = false,
                        filterStartDatePassed = false,
                        filterEndDatePassed = false;

                    $.each(tr.children(), function(b, td) {
                        $.each(td.childNodes, function(c, tdElement) {
                            var data = '';
                            if (tdElement.nodeType == 1) {
                                if (tdElement.type != 'hidden' && tdElement.nodeName != 'IMG')
                                    data = tdElement.value ? tdElement.value : tdElement.textContent;
                            } else if (tdElement.nodeType == 3)
                                data = tdElement.data;

                            $.each(columns, function(a, th) {
                                if (data.toUpperCase().includes(dataToSearch) && th == thead[b])
                                    filteringPassed = true;
                            });

                            if (myTable.filterByType) {
                                if (filterTypeValue.toUpperCase() == 'ALL')
                                    filterTypePassed = true;
                                else if (data.toUpperCase() == filterTypeValue.toUpperCase())
                                    filterTypePassed = true;
                            }

                            if (myTable.filterByDate) {
                                if (isDate(data)) {
                                    var date = new Date(data);
                                    if (!startDate)
                                        filterStartDatePassed = true;
                                    else if (isDataExist(start, b)) {
                                        if (date.getTime() >= startDate.getTime())
                                            filterStartDatePassed = true;
                                    }
                                    if (!endDate)
                                        filterEndDatePassed = true;
                                    else if (isDataExist(end, b)) {
                                        if (date.getTime() <= endDate.getTime())
                                            filterEndDatePassed = true;
                                    }
                                }
                            }
                        });
                    });

                    if (myTable.filterByType)
                        filteringPassed = filteringPassed && filterTypePassed ? true : false;

                    if (myTable.filterByDate)
                        filteringPassed = filteringPassed && filterStartDatePassed && filterEndDatePassed ? true : false;

                    if (filteringPassed && myTable.checkBox)
                        holdRowNum.push(d);

                    return filteringPassed;
                });



            if (myTable.filterByType) {
                var filterTypeTh = myTable.columnsToShowForFilteredType[filterType] ? myTable.columnsToShowForFilteredType[filterType] : thead,
                    currentThead = [];

                $.each(filterTypeTh, function(a, th) {
                    currentThead.push(myTable.tableHeadings[th]);
                });

                $(myTable.table + ' thead').html(currentThead);

                var tableData = [];

                $.each(tbody, function(a, tr) {
                    var trElem = document.createElement('tr');
                    $.each(tr.children(), function(b, td) {
                        if (isDataExist(filterTypeTh, b))
                            trElem.appendChild(this.cloneNode(true));
                    });
                    tableData.push(trElem);
                });
                tbody = tableData;
            }

            if (!myTable.disableLimit) {
                var dataLength = tbody.length;
                pages = parseInt(dataLength == 0 ? 0 : (dataLength % limit == dataLength ? 1 : (dataLength % limit > 0 ? dataLength / limit + 1 : dataLength / limit)));
                page = page > pages ? 1 : page;

                var dataStart = (page - 1) * limit,
                    dataLimit = dataStart + limit;

                tbody = $.grep(tbody, function(td, i) {
                    if (i >= dataStart && i < dataLimit) {
                        if (myTable.checkBox)
                            rowNumber.push(holdRowNum[i]);

                        return true;
                    }
                });
            }

            if (tbody.length == 0)
                tbody = '<tr><td colspan="' + thead.length + '" align="center">No records found.</td></tr>';

            $(myTable.table + ' tbody').html(tbody);

            setCboxAllValue();
            appendTablePages();
        }


        function isDataExist(arr, b) {
            var exist = false;

            $.each(arr, function(c, col) {
                if (col == b)
                    exist = true;
            });
            return exist;
        }

        function isDate(date) {
            return (new Date(date) !== 'Invalid Date') && !isNaN(new Date(date));
        }

        function appendTableTopDiv() {
            var html = '<div id="' + tableAsPrefix() + '_topDiv">';

            if (myTable.filterByDate)
                html += '<div id="' + tableAsPrefix() + '_filterDate">\
                    Start from: <input type="date" name="start"><button name="resetStart" class="btn btn-light">Reset</button>\
                    Ends to: <input type="date" name="end"><button name="resetEnd" class="btn btn-light">Reset</button>\
                </div>';

            html += '<div class="form-group row">';

            if (!myTable.disableLimit)
                html += '<div id="' + tableAsPrefix() + '_dataLimit" class ="myTables_length col-sm-6 col-md-6">\
                    Show <select name="">\
                        <option value="">10</option>\
                        <option value="">25</option>\
                        <option value="">50</option>\
                        <option value="">100</option>\
                    </select> Entries\
                </div>';

            if (!myTable.disableSearch)
                html += '<div id="' + tableAsPrefix() + '_filterData" class ="myTables_filter col-sm-6 col-md-6">\
                    Search: <input type="text" value="">\
                </div>';

            $(html + '</div></div>').insertBefore(myTable.table);
        }

        function appendTableBottomDiv() {
            var html = '<div id="' + tableAsPrefix() + '_bottomDiv" class="form-group row">';

            if (!myTable.disableSelectAll && myTable.checkBox)
                html += '<div id="' + tableAsPrefix() + '_selectAll" class ="myTables_selectAll col-md-3"><input type="checkbox">Select All</div>';

            if (!myTable.disableSelectedCount && myTable.checkBox)
                html += '<div id="' + tableAsPrefix() + '_selectedCount" class="myTables_selectedCount col-md-3">0 selected data.</div>';

            if (!myTable.disablePagination)
                html += '<div id="' + tableAsPrefix() + '_pagination" clas="myTables_paginate" style="margin-left:auto"></div>';

            $(html + '</div>').insertAfter(myTable.table);
        }

        function appendTablePages() {
            var tablePage = '<button class="btn btn-light" ' + (pages == 0 ? 'disabled' : '') + '>Previous</button>',
                pagesArr = [1];

            if (pages > 7) {
                pagesArr[6] = pages;
                if (page < 5) {
                    for (var i = 2; i < 6; i++)
                        pagesArr[i - 1] = i;
                } else if (page > pages - 4) {
                    for (var i = pages - 4; i < pages; i++)
                        pagesArr[i - (pages - 6)] = i;
                } else {
                    pagesArr[2] = page - 1;
                    pagesArr[3] = page;
                    pagesArr[4] = page + 1;
                }
            } else {
                pagesArr = pages > 0 ? [1] : [];
                for (var i = 2; i <= pages; i++)
                    pagesArr[i - 1] = i;
            }
            for (var i = 0; i < pagesArr.length; i++)
                tablePage += '<button class="btn btn-' + (page == pagesArr[i] ? 'primary"' : 'light"') + (pagesArr[i] ? '' : ' disabled') + '>' + (pagesArr[i] ? pagesArr[i] : '...') + '</button>';

            $('#' + tableAsPrefix() + '_pagination').html(tablePage + '<button class="btn btn-light" ' + (pages == 0 ? 'disabled' : '') + '>Next</button>');
        }

        function tableAsPrefix() {
            return myTable.table.substr(0, 1) == '#' || myTable.table.substr(0, 1) == '.' ? myTable.table.substr(1) : myTable.table;
        }
    }

    checkedTableRow(all = false) {
        if (all)
            return $.grep(this.allTableData, function(tr, i) {
                if (tr.children()[0].childNodes[0].checked)
                    return true;
            });

        var hold = [],
            c = 0;

        $(this.table + ' tbody tr').each(function(i) {
            if ($(this).children()[0].childNodes[0].checked) {
                hold[c] = $(this);
                c++;
            }
        });

        return hold;
    }

    hideTopDiv(hide = true) {
        var table = this.table.substr(0, 1) == '#' || this.table.substr(0, 1) == '.' ? this.table.substr(1) : this.table;
        hide ? $('#' + table + '_topDiv').hide() : $('#' + table + '_topDiv').show();
    }

    hideBottomDiv(hide = true) {
        var table = this.table.substr(0, 1) == '#' || this.table.substr(0, 1) == '.' ? this.table.substr(1) : this.table;
        hide ? $('#' + table + '_bottomDiv').hide() : $('#' + table + '_bottomDiv').show();
    }

    eachTableCell(arr, func) {
        $.each(arr, function(a, tr) {
            var data1 = [];
            $.each(tr.children(), function(b, td) {
                var data = [];
                $.each(td.childNodes, function(c, tdElement) {
                    data.push(tdElement.nodeType == 3 ? tdElement.data : tdElement);
                });
                data = data.length == 0 ? '' : (data.length == 1 ? data[0] : data);
                data1.push(data);
            });
            func(data1, a);
        });
    }
}