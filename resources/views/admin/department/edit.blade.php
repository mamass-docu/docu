@extends('layouts.admin.main')
@section('content')
    

    <form action="{{route('admin.department.update', ['department' => $department->department_id])}}" method="post">
        @csrf
        @method('put')

        {{-- <input type="hidden" name="department_id" value="{{$department->department_id}}"> --}}

        <label for="">Department</label>
        <input type="text" name="department_name" value="{{old('department_name') ?? $department->department_name}}">
        @error('department_name')
            {{$message}}
        @enderror

        <br>

        <label for="">Priority Level</label>
        <select name="priority">
            <option value="High" {{old('priority') ? (old('priority') == 'High' ? 'selected' : '') : ($department->priority == 'High' ? 'selected' : '')}}>High</option>
            <option value="Medium" {{old('priority') ? (old('priority') == 'Medium' ? 'selected' : '') : ($department->priority == 'Medium' ? 'selected' : '')}}>Medium</option>
            <option value="Low" {{old('priority') ? (old('priority') == 'Low' ? 'selected' : '') : ($department->priority == 'Low' ? 'selected' : '')}}>Low</option>
        </select>
        @error('priority')
            {{$message}}
        @enderror

        <br>

        <button type="submit">Save</button>
    </form>


@endsection