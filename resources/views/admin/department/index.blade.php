@extends('layouts.admin.main')
@section('content')


    <table id="departmentsTable" class="table table-bordered">
        <thead>
            <th><input type="checkbox" name="" id=""></th>
            <th>Department Name</th>
            <th>Priority</th>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td><input type="checkbox" value="{{$department->department_id}}"></td>
                    <td>{{$department->department_name}}</td>
                    <td>{{$department->priority}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="table_manip">
        <button id="massEditBtn" class="btn btn-primary" data-target="#massEditDepartmentModal" data-toggle="modal" disabled>Edit</button>
        <button id="massDeleteBtn" class="btn btn-danger" data-target="#massDeleteDepartmentModal" data-toggle="modal" disabled>Delete</button>
    </div>

    
    <div class="modal fade bd-example-modal-lg" id="massEditDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="massEditDepartmentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massEditDepartmentModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <form id="massEditDepartmentModalForm" action="{{route('admin.department.massEdit')}}" method="GET" enctype="multipart/form-data">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massEditDepartmentModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="massEditDepartmentModalEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="massDeleteDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="massDeleteDepartmentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massDeleteDepartmentModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deleteMessage"></div>

                    <form id="massDeleteDepartmentModalForm" action="{{route('admin.department.massDelete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massDeleteDepartmentModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="massDeleteDepartmentModalDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}">
    
    <script src="{{asset('js/department/index.js')}}"></script>

@endsection