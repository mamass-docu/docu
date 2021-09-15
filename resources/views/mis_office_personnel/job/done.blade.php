@extends('layouts.mis_office_personnel.main')
@section('content')
    

    <form action="{{route('mis_office_personnel.job.done')}}" method="post">
        @csrf

        <input type="hidden" name="job_id" value="{{$job_id}}">
        <input type="hidden" name="user_id" value="{{$user_id}}">

        <label for="">Problems Found</label>
        <textarea name="problems_found" id="" cols="30" rows="3"></textarea>
        <br>
        <label for="">Solution Applied</label>
        <textarea name="solution_applied" id="" cols="30" rows="3"></textarea>
        <br>
        <label for="">Recommendation</label>
        <textarea name="recommendation" id="" cols="30" rows="3"></textarea>
        <br>
        <label for="">Remarks</label>
        <select name="remarks" id="" required>
            <option value=""></option>
            <option value="Accomplished">Accomplished</option>
            <option value="Broken">Broken</option>
        </select>
        <br>
        <a href="{{route('mis_office_personnel.job.index')}}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Save</button>
    </form>


@endsection