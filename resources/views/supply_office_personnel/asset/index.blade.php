@extends('layouts.admin.main')
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
                <th><input type="checkbox" name="" id=""></th>
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
                        <td><input type="checkbox" value="{{$asset->asset_id}}"></td>
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

        <div class="table_manip">
            <button id="massEditBtn" class="btn btn-primary" data-target="#massEditAssetModal" data-toggle="modal" disabled>Edit</button>
            <button id="massDeleteBtn" class="btn btn-danger" data-target="#massDeleteAssetModal" data-toggle="modal" disabled>Delete</button>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="massEditAssetModal" tabindex="-1" role="dialog" aria-labelledby="massDeleteAssetModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massDeleteAssetModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <form id="massEditAssetModalForm" action="{{route('admin.asset.massEdit')}}" method="GET">
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="massEditAssetModalCancel">Cancel</button>
                    <button type="button" class="btn btn-info" id="massEditAssetModalEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="massDeleteAssetModal" tabindex="-1" role="dialog" aria-labelledby="massDeleteAssetModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massDeleteAssetModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deleteMessage"></div>

                    <form id="massDeleteAssetModalForm" action="{{route('admin.asset.massDelete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="massDeleteAssetModalCancel">Cancel</button>
                    <button type="button" class="btn btn-danger" id="massDeleteAssetModalDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    
    <script src="{{asset('vendor/qrcode-scanner/instascan.min.js')}}"></script>

    <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}">
    
    <script src="{{asset('js/asset/index.js')}}"></script>
    <script src="{{asset('js/asset/qrcodeScan.js')}}"></script>

@endsection