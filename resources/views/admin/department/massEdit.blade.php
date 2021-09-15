@extends('layouts.admin.main')
@section('content')


    <form action="{{route('admin.department.massUpdate')}}" method="POST">
        @csrf

        <table id="departmentsTable" class="table table-bordered">
            <thead>
                <th>Department Name</th>
                <th>Priority</th>
            </thead>
            <tbody>
                @foreach ($departments as $i => $department)
                    <tr>
                        <td>
                            <input type="hidden" name="department_id[]" value="{{$department->department_id}}">
                            <input type="text" name="department_name[]" list="department_names" value="{{old('department_name.'.$i) ?? $department->department_name}}">
                            @error('department_name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <select name="priority[]">
                                <option value="High" {{old('priority.'.$i) ? (old('priority.'.$i) == 'High' ? 'selected' : '') : ($department->priority == 'High' ? 'selected' : '')}}>High</option>
                                <option value="Medium" {{old('priority.'.$i) ? (old('priority.'.$i) == 'Medium' ? 'selected' : '') : ($department->priority == 'Medium' ? 'selected' : '')}}>Medium</option>
                                <option value="Low" {{old('priority.'.$i) ? (old('priority.'.$i) == 'Low' ? 'selected' : '') : ($department->priority == 'Low' ? 'selected' : '')}}>Low</option>
                            </select>
                        </td>
                        <td><input type="button" value="X" class="X btn btn-danger"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{route('admin.department.index')}}" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-success" id = "btnUpdate" type="submit">Update</button>

    </form>

    
    <script>
        noRecordToEdit();
        
        $('#departmentsTable').on('click', 'input.X', function() {
            $(this).parents('tr').remove();

            noRecordToEdit();
        });

        function noRecordToEdit() {
            if ($('#departmentsTable tbody tr').length == 0) {
                $('#departmentsTable tbody').html('<tr><td colspan="' + $('#departmentsTable thead th').length + '" align="center">No records to edit.</td></tr>');
                $('#btnUpdate').attr('disabled', true);
            }
        }

    </script>

@endsection