@extends('layouts.supply_office_personnel.main')
@section('content')

    
    <datalist name="" id="asset_id_list">
        @foreach ($assets as $asset)
            <option value="{{$asset->asset_id}}">
        @endforeach
    </datalist>


    <form action="{{route('supply_office_personnel.job.update', ['job' => $job->job_id])}}" method="post" id="editJobForm">
        @csrf
        @method('put')


        <label for="serviceable_asset_id">Asset ID</label>
        <input type="text" list="asset_id_list" name="serviceable_asset_id" value="{{old('serviceable_asset_id') ?? $job->serviceable_asset_id}}" required>
        @error('serviceable_asset_id')
            {{$message}}
        @enderror

        <br>

        <label for="service_type">Type of Service</label>
        <select name="service_type" id="service_typeSelect" required>
            @if (!Str::contains(old('service_type') ?? $job->service_type, 'others: '))
                <option value="{{old('service_type') ?? $job->service_type}}">{{old('service_type') ?? $job->service_type}}</option>
            @else
                <option value="others">Others: Please specify.</option>
            @endif
            <option value="Repair/Troubleshoot">Repair/Troubleshoot</option>
            <option value="Software Installation">Software Installation</option>
            <option value="Formatting">Formatting</option>
            <option value="Network Connectivity">Network Connectivity</option>
            <option value="Internet Service">Internet Service</option>
        </select>
        <br>
        <label for="">Others: Specify here.</label>
        <input type="text" name="service_type" id="service_typeInput" value="{{
                    Str::contains(old('service_type') ?? $job->service_type, 'others: ') 
                        ? Str::substr(old('service_type') ?? $job->service_type, 8) : ''
            }}"{{
                    Str::contains(old('service_type') ?? $job->service_type, 'others: ') ? 'required' : 'disabled'
            }}>
        @error('service_type')
            {{$message}}
        @enderror

        <br>

        <label for="client_contact_no">Contact No.</label>
        <input type="number" name="client_contact_no" value="{{old('client_contact_no') ?? $job->client_contact_no}}" required>
        @error('client_contact_no')
            {{$message}}
        @enderror

        <br>

        <label for="client_request_problem">Problem</label>
        <textarea name="client_request_problem" cols="30" rows="3">{{old('client_request_problem') ?? $job->client_request_problem}}</textarea>
        @error('client_request_problem')
            {{$message}}
        @enderror

        <br>

        <input type="button" value="Save" id="save" class="btn btn-success">

    </form>


    <script>
        $('#service_typeSelect').on('change', function(){
            if ($(this).val() == 'others')
                $('#service_typeInput').prop('disabled', false);
            else{
                $('#service_typeInput').val('');
                $('#service_typeInput').prop('disabled', true);
            }
        });
        
        $('#save').on('click', function(){
            if ($('#service_typeInput').val().length > 0)
                $('#service_typeInput').val('others: ' + $('#service_typeInput').val());
            
            $('#editJobForm').submit();
        });
    </script>

@endsection