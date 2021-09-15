@extends('layouts.supply_office_personnel.main')
@section('content')

    @foreach ($requested_jobs as $job)
        <h4>{{$job->job_no}}</h4>
        <h5>
            {{$job->asset_name}}
            <br>
            {{$job->department_name}} <a href="{{route('supply_office_personnel.job.edit', ['job' => $job->job_id])}}">Edit</a> 
                <button id="delete" data-job_id = "{{$job->job_id}}" data-target="#jobDeleteModal" data-toggle="modal">Delete</button>
            <br>
            <h6>
                @if (!$job->continue_service_date && $job->pause_service_date)
                    In Pause
                @elseif ($job->start_service_date)
                    In Process
                @else
                    Pending
                @endif
            </h6>
        </h5>
        <hr>
    @endforeach

    @foreach ($job_to_verify as $job)
        <h4>{{$job->job_no}}</h4>
        <h5>{{$job->asset_name}}</h5>
        <a href="{{route('supply_office_personnel.job.verify', ['job' => $job->job_id])}}">Verify</a>
    @endforeach


    <div class="modal fade bd-example-modal-lg" id="jobDeleteModal" tabindex="-1" role="dialog" aria-labelledby="jobDeleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDeleteModalTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You want to delete.

                    <form id="jobDeleteModalForm" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="jobDeleteModalDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    

    {{-- <script src="{{asset('vendor/myTables/myTables.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/myTables/myTables.css')}}"> --}}
    
    <script>
        $('#delete').click(function(){
            $('#jobDeleteModal').on('show.bs.modal', function(e) {
                var job_id = $(e.relatedTarget).data('job_id'),
                    baseUrl =  '{{url('')}}',
                    url = baseUrl + "/supply_office_personnel/job/" + job_id;

                $('#jobDeleteModalDelete').click(function(){
                    $('#jobDeleteModalForm').attr('action', url);
                    $('#jobDeleteModalForm').submit();
                });
            });
        });
    </script>

@endsection