@extends('layouts.mis_office_personnel.main')
@section('content')


    <div id="assetsTable_portion">
        <select name="" id="assetsTable_type">
            <option value="">All</option>
            <option value="">ICT</option>
            <option value="">Computer Set</option>
        </select>
        
        <div id="qrScan_section">
            <video id="scanQr" width="350px; height: 400px;"></video>
            <input type="radio" name="scan" id="front" disabled> Front
            <input type="radio" name="scan" id="back" disabled> Back
        </div>

        <table id="assetsTable" class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Person-in-charge</th>
                <th>Office</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Processor</th>
                <th>Memory</th>
                <th>Video Card</th>
                <th>Lan Card</th>
                <th>Sound Card</th>
                <th>Hard Drive</th>
                <th>Optical Drive</th>
                <th>Monitor</th>
                <th>Mouse</th>
                <th>Keyboard</th>
                <th>AVR</th>
                <th>Serviceable</th>
                <th>Precurement Date</th>
                <th>Image</th>
            </thead>
            <tbody>
                @foreach ($assets as $asset)
                    <tr>
                        <td>{{$asset->asset_name}}</td>
                        <td>{{$asset->name}}</td>
                        <td>{{$asset->department_name}}</td>
                        <td>{{$asset->type}}</td>
                        <td>{{$asset->brand}}</td>
                        <td>{{$asset->model}}</td>
                        <td>{{$asset->processor}}</td>
                        <td>{{$asset->memory}}</td>
                        <td>{{$asset->video_card}}</td>
                        <td>{{$asset->lan_card}}</td>
                        <td>{{$asset->sound_card}}</td>
                        <td>{{$asset->hard_drive}}</td>
                        <td>{{$asset->optical_drive}}</td>
                        <td>{{$asset->monitor}}</td>
                        <td>{{$asset->mouse}}</td>
                        <td>{{$asset->keyboard}}</td>
                        <td>{{$asset->avr}}</td>
                        <td>{{$asset->serviceable == '1' ? 'true' : 'false'}}</td>
                        <td>{{$asset->precurement_date}}</td>
                        <td><img style="width: 40px;height: 35px;" src="{{asset('/images/users/'.$asset->asset_image_name)}}" alt=""></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
    <script src="{{asset('vendor/qrcode-scanner/instascan.min.js')}}"></script>

    <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}">
    
    <script src="{{asset('js/asset/qrcodeScan.js')}}"></script>

    <script>
        var table = new myTable({
            table: '#assetsTable',
            filterByType: '#assetsTable_type',
            filterByDate: true,
            columnsToFilterDate: { start: [19], end: [19] },
            columnsToShowForFilteredType: {
                ICT: [0, 1, 2, 4, 5, 17, 18, 19],
                Computer_Set: [0, 1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            },
        });
    </script>

@endsection