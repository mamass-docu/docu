@extends('layouts.admin.main')
@section('content')
    

    <form action="{{route('admin.department.store')}}" method="post">
        @csrf

        <label for="">Department</label>
        <input type="text" name="department_name" value="{{old('department_name')}}">
        @error('department_name')
            {{$message}}
        @enderror

        <br>

        <label for="">Priority Level</label>
        <select name="priority">
            <option value="High" {{old('priority') == 'High' ? 'selected' : ''}}>High</option>
            <option value="Medium" {{old('priority') == 'Medium' ? 'selected' : ''}}>Medium</option>
            <option value="Low" {{old('priority') == 'Low' ? 'selected' : ''}}>Low</option>
        </select>
        @error('priority')
            {{$message}}
        @enderror

        <br>

        <button type="submit">Save</button>
    </form>


@endsection