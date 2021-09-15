@extends('layouts.admin.main')
@section('content')


    <form action="{{route('admin.user.massUpdate')}}" method="POST">
        @csrf

        <datalist id="department_names">
            @foreach ($departments as $department)
                <option value="{{$department->department_name}}">
            @endforeach
        </datalist>

        <table id="usersTable" class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Image</th>
                <th>Remove</th>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <td>
                            <input type="hidden" name="user_id[]" value="{{$user->user_id}}">
                            <input type="text" name="name[]" value="{{old('name.'.$i) ?? $user->name}}">
                            @error('name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="department_name[]" list="department_names" value="{{old('department_name.'.$i) ?? $user->department_name}}">
                            @error('department_name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <select name="role[]" id="">
                                <option value="{{old('role.'.$i) ?? $user->role}}">
                                    {{Str::title(Str::of(old('role.'.$i) ?? $user->role)->replace('_', ' '))}}
                                </option>
                                <option value="employee">Employee</option>
                                <option value="mis_office_personnel">MIS Office Personnel</option>
                                <option value="supply_office_personnel">Supply Office Personnel</option>
                            </select>
                            @error('role.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="file" name="user_image[]" accept="image/*">
                            @error('user_image.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td><input type="button" value="X" class="X btn btn-danger"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{route('user.index')}}" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-success" id = "btnUpdate" type="submit">Update</button>

    </form>

    
    <script>
        noRecordToEdit();
        
        $('#usersTable').on('click', 'input.X', function() {
            $(this).parents('tr').remove();

            noRecordToEdit();
        });

        function noRecordToEdit() {
            if ($('#usersTable tbody tr').length == 0) {
                $('#usersTable tbody').html('<tr><td colspan="' + $('#usersTable thead th').length + '" align="center">No records to edit.</td></tr>');
                $('#btnUpdate').attr('disabled', true);
            }
        }

    </script>

@endsection