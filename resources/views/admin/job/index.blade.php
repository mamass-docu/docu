@extends('layouts.admin.main')
@section('content')


    <table id="jobsTable" class="table table-bordered">
        <thead>
            <th><input type="checkbox" name="" id=""></th>
            <th>Asset Id</th>
            <th>Client Name</th>
            <th>Type Of Service</th>
            <th>Contact No.</th>
            <th>Problem</th>
            <th>Date of Request</th>
            <th>Time of Request</th>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td><input type="checkbox" value="{{$job->job_id}}"></td>
                    <td>{{$job->serviceable_asset_id}}</td>
                    <td>{{$job->name}}</td>
                    <td>{{$job->service_type}}</td>
                    <td>{{$job->client_contact_no}}</td>
                    <td>{{$job->client_request_problem}}</td>
                    <td>{{$job->request_date}}</td>
                    <td>{{$job->request_time}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="table_manip">
        <button id="massEditBtn" class="btn btn-primary" data-target="#massEditJobModal" data-toggle="modal" disabled>Edit</button>
        <button id="massDeleteBtn" class="btn btn-danger" data-target="#massDeleteJobModal" data-toggle="modal" disabled>Delete</button>
    </div>

    
    <div class="modal fade bd-example-modal-lg" id="massEditJobModal" tabindex="-1" role="dialog" aria-labelledby="massEditJobModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massEditJobModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <form id="massEditJobModalForm" action="{{route('admin.job.massEdit')}}" method="GET" enctype="multipart/form-data">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massEditJobModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="massEditJobModalEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="massDeleteJobModal" tabindex="-1" role="dialog" aria-labelledby="massDeleteJobModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massDeleteJobModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deleteMessage"></div>

                    <form id="massDeleteJobModalForm" action="{{route('admin.job.massDelete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massDeleteJobModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="massDeleteJobModalDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}">
    
    <script src="{{asset('js/job/index.js')}}"></script>

@endsection