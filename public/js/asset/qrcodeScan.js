var qrCamera,
    scanning = [false, false];

let scanner = new Instascan.Scanner({ video: document.getElementById('scanQr') });
Instascan.Camera.getCameras().then(function(cameras) {
    if (cameras.length > 1)
        $('#qrScan_section input#back').prop('disabled', false);
    if (cameras.length > 0)
        $('#qrScan_section input#front').prop('disabled', false);

    qrCamera = cameras;
}).catch(function(e) {
    console.error(e);
});

scanner.addListener('scan', function(c) {
    $('#assetsTable_filterData input').val(c);
    $('#assetsTable_filterData input').keyup();
});

$('#qrScan_section input').on('click', function() {
    var cam = $(this).attr('id') == 'front' ? 0 : 1;

    scanner.stop();

    if (scanning[cam])
        $(this).prop('checked', false);
    else {
        scanner.start(qrCamera[cam]);

        if (scanning[cam == 1 ? 0 : 1])
            scanning[cam == 1 ? 0 : 1] = false;
    }

    scanning[cam] = !scanning[cam];
});