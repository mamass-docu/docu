@extends('layouts.mis_office_personnel.main')
@section('content')
    

    @foreach ($high_priority_jobs as $job)
        <div class="alert alert-danger">
            <h2>{{$job->priority}}</h2>
            <h3> {{$job->job_id}} </h3>
            <h5>
                {{$job->name}}
                <br>
                {{$job->service_type}}
            </h5>
        </div>
    @endforeach

    @foreach ($medium_priority_jobs as $job)
        <div class="alert alert-warning">
            <h2>{{$job->priority}}</h2>
            <h3> {{$job->job_id}} </h3>
            <h5>
                {{$job->name}}
                <br>
                {{$job->service_type}}
            </h5>
        </div>
    @endforeach
    
    @foreach ($low_priority_jobs as $job)
        <div class="alert alert-primary">
            <h2>{{$job->priority}}</h2>
            <h3> {{$job->job_id}} </h3>
            <h5>
                {{$job->name}}
                <br>
                {{$job->service_type}}
            </h5>
        </div>
    @endforeach

    

    @if($paused_job)
        <div class="alert alert-secondary">
            <h2>{{$paused_job->priority}}</h2>
            <h4>Paused</h4>
            <h3> {{$paused_job->job_id}} </h3>
            <h5>
                {{$paused_job->name}}
                <br>
                {{$paused_job->service_type}}
            </h5>
        </div>
    @endif

    @if($processing_job)
        <div class="alert alert-info">
            <h2>{{$processing_job->priority}}</h2>
            <h4>Start</h4>
            <h3> {{$processing_job->job_id}} </h3>
            <h5>
                {{$processing_job->name}}
                <br>
                {{$processing_job->service_type}}
            </h5>
        </div>
    @endif

    <form action="{{route('mis_office_personnel.job.action')}}" method="post" id="showOrderedJobForm">
        @csrf

        <input type="hidden" name="action" id="action">
        
        @if ($processing_job)
            <input type="hidden" name="current_job_id" value="{{$processing_job->job_id}}">
            <input type="hidden" name="current_user_id" value="{{$processing_job->client_id}}">

            <input type="button" value="Pause" id="pause" class="btn btn-secondary">
            <br>
            <a href="{{route('mis_office_personnel.job.show', 
                ['job' => $processing_job->job_id, 'user' => $processing_job->client_id])}}" class="btn btn-success">Done</a>
            <br>
            <input type="button" value="Cancel" id="cancel" class="btn btn-warning">
        @elseif($paused_job)
            <input type="hidden" name="current_job_id" value="{{$paused_job->job_id}}">
            <input type="hidden" name="current_user_id" value="{{$paused_job->client_id}}">
            
            <br>
            <input type="button" value="Cancel" id="cancel" class="btn btn-warning">
            <br>
            <input type="button" value="Continue" id="continue" class="btn btn-primary">
            @if (($paused_job->priority == 'Low' && ($high_priority_jobs || $medium_priority_jobs)) ||
                ($paused_job->priority == 'Medium' && $high_priority_jobs))
                <br>
                <input type="button" value="Start" id="start" class="btn btn-primary">

                @if($high_priority_jobs)
                    <input type="hidden" name="new_job_id" value="{{$high_priority_jobs[0]->job_id}}">
                    <input type="hidden" name="new_user_id" value="{{$high_priority_jobs[0]->client_id}}">
                @elseif($medium_priority_jobs)
                    <input type="hidden" name="new_job_id" value="{{$medium_priority_jobs[0]->job_id}}">
                    <input type="hidden" name="new_user_id" value="{{$medium_priority_jobs[0]->client_id}}">
                @endif
            @endif
        @else
            @if($high_priority_jobs)
                <input type="hidden" name="new_job_id" value="{{$high_priority_jobs[0]->job_id}}">
                <input type="hidden" name="new_user_id" value="{{$high_priority_jobs[0]->client_id}}">
            @elseif($medium_priority_jobs)
                <input type="hidden" name="new_job_id" value="{{$medium_priority_jobs[0]->job_id}}">
                <input type="hidden" name="new_user_id" value="{{$medium_priority_jobs[0]->client_id}}">
            @elseif($low_priority_jobs)
                <input type="hidden" name="new_job_id" value="{{$low_priority_jobs[0]->job_id}}">
                <input type="hidden" name="new_user_id" value="{{$low_priority_jobs[0]->client_id}}">
            @endif
        
            <br>
            <input type="button" value="Start" id="start" class="btn btn-primary">
        @endif

    </form>

    <script>
        $('#showOrderedJobForm').on('click', 'input', function(){
            $('#action').val($(this).attr('id'));
            $('#showOrderedJobForm').submit();
        });
    </script>

@endsection