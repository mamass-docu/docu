@extends('layouts.admin.main')
@section('content')


    
    <datalist name="" id="asset_id_list">
        @foreach ($assets as $asset)
            <option value="{{$asset->asset_id}}">
        @endforeach
    </datalist>

    <datalist name="" id="user_name_list">
        @foreach ($users as $user)
            <option value="{{$user->name}}">
        @endforeach
    </datalist>

    <form action="{{route('admin.job.massUpdate')}}" id="massUpdateJobForm" method="POST">
        @csrf

        <table id="jobsTable" class="table table-bordered">
            <thead>
                <th>Asset Id</th>
                <th>Client Name</th>
                <th>Type Of Service</th>
                <th>Contact No.</th>
                <th>Problem</th>
                <th>Date of Request</th>
                <th>Time of Request</th>
            </thead>
            <tbody>
                @foreach ($jobs as $i => $job)
                    <tr>
                        <td>
                            <input type="hidden" name="job_id[]" value="{{$job->job_id}}">
                            <input type="text" name="serviceable_asset_id[]" list="asset_id_list" value="{{old('serviceable_asset_id.'.$i) ?? $job->serviceable_asset_id}}">
                            @error('serviceable_asset_id.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="name[]" list="user_name_list" value="{{old('name.'.$i) ?? $job->name}}">
                            @error('name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <select name="service_type[{{$i}}]" class="service_typeSelect" required>
                                <option value="{{old('service_type.'.$i) ?? $job->service_type}}">{{old('service_type.'.$i) ?? $job->service_type}}</option>
                                <option value="Repair/Troubleshoot">Repair/Troubleshoot</option>
                                <option value="Software Installation">Software Installation</option>
                                <option value="Formatting">Formatting</option>
                                <option value="Network Connectivity">Network Connectivity</option>
                                <option value="Internet Service">Internet Service</option>
                                <option value="others">Others: Please specify.</option>
                            </select>
                            <br>
                            <input type="text" name="service_type[{{$i}}]" class="service_typeInput" value="{{
                                        Str::contains(old('service_type.'.$i) ?? $job->service_type, 'others: ') 
                                            ? Str::substr(old('service_type.'.$i) ?? $job->service_type, 8) : ''
                                }}"{{
                                        Str::contains(old('service_type.'.$i) ?? $job->service_type, 'others: ') ? 'required' : 'disabled'
                                }}>
                            @error('service_type.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="number" name="client_contact_no[]" value="{{old('client_contact_no') ?? $job->client_contact_no}}">
                            @error('client_contact_no.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <textarea name="client_request_problem[]" id="" cols="30" rows="3">{{old('client_request_problem.'.$i ?? $job->client_request_problem)}}</textarea>
                            @error('client_request_problem.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="date" name="request_date[]" value="{{old('request_date.'.$i) ?? $job->request_date}}">
                            @error('request_date.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="time" name="request_time[]" value="{{old('request_time.'.$i) ?? $job->request_time}}">
                            @error('request_time.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td><input type="button" value="X" class="X btn btn-danger"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{route('admin.job.index')}}" class="btn btn-secondary">Cancel</a>
        <input type="button" id="btnUpdate" class="btn btn-success" value="Update">

    </form>

    
    <script>
        noRecordToEdit();
        
        $('.service_typeSelect').on('change', function(){
            var others =  $(this).parent().children()[3];
            
            if ($(this).val() == 'others')
                $(others).prop('disabled', false);
            else{
                $(others).val('');
                $(others).prop('disabled', true);
            }
        });
        
        $('#btnUpdate').on('click', function(){
            $('.service_typeInput').each(function(){
                $(this).val('others: ' + $(this).val());
            });
            
            $('#massUpdateJobForm').submit();
        });

        $('#jobsTable').on('click', 'input.X', function() {
            $(this).parents('tr').remove();

            noRecordToEdit();
        });

        function noRecordToEdit() {
            if ($('#jobsTable tbody tr').length == 0) {
                $('#jobsTable tbody').html('<tr><td colspan="' + $('#jobsTable thead th').length + '" align="center">No records to edit.</td></tr>');
                $('#btnUpdate').attr('disabled', true);
            }
        }

    </script>

@endsection