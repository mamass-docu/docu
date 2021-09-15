@extends('layouts.admin.main')
@section('content')


    <table id="usersTable" class="table table-bordered">
        <thead>
            <th><input type="checkbox" name="" id=""></th>
            <th>Name</th>
            <th>Department</th>
            <th>Role</th>
            <th>Image</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><input type="checkbox" value="{{$user->user_id}}"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->department_name}}</td>
                    <td>{{$user->role}}</td>
                    <td><img style="width: 40px;height: 35px;" src="{{asset('/images/users/'.$user->image_name)}}" alt=""></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="table_manip">
        <button id="massEditBtn" class="btn btn-primary" data-target="#massEditUserModal" data-toggle="modal" disabled>Edit</button>
        <button id="massDeleteBtn" class="btn btn-danger" data-target="#massDeleteUserModal" data-toggle="modal" disabled>Delete</button>
    </div>

    
    <div class="modal fade bd-example-modal-lg" id="massEditUserModal" tabindex="-1" role="dialog" aria-labelledby="massEditUserModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massEditUserModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <form id="massEditUserModalForm" action="{{route('admin.user.massEdit')}}" method="GET" enctype="multipart/form-data">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massEditUserModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="massEditUserModalEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="massDeleteUserModal" tabindex="-1" role="dialog" aria-labelledby="massDeleteUserModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massDeleteUserModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deleteMessage"></div>

                    <form id="massDeleteUserModalForm" action="{{route('admin.user.massDelete')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="massDeleteUserModalCancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="massDeleteUserModalDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}">
    
    <script src="{{asset('js/user/index.js')}}"></script>

@endsection