@extends('layouts.admin.main')
@section('content')


    <form action="{{route('admin.asset.massUpdate')}}" method="POST">
        @csrf

        <input type="hidden" name="type" value="{{$type}}">
        
        <datalist id="user_names">
            @foreach ($users as $user)
                <option value="{{$user->name}}">
            @endforeach
        </datalist>

        <datalist id="department_names">
            @foreach ($departments as $department)
                <option value="{{$department->department_name}}">
            @endforeach
        </datalist>

        <table id="assetsTable" class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Person-in-charge</th>
                <th>Office</th>
                <th>Type</th>
                @if ($type == 'ICT' || $type == 'All')
                    <th>Brand</th>
                    <th>Model</th>
                @endif
                @if($type == 'Computer Set' || $type == 'All')
                    <th>Processor</th>
                    <th>Memory</th>
                    <th>Video Card</th>
                    <th>Lan Card</th>
                    <th>Sound Card</th>
                    <th>Hard Drive</th>
                    <th>Optical Drive</th>
                    <th>Monitor</th>
                    <th>Mouse</th>
                    <th>Keyboard</th>
                    <th>AVR</th>
                @endif
                <th>Serviceable</th>
                <th>Precurement Date</th>
                <th>Image</th>
                <th>Remove</th>
            </thead>
            <tbody>
                @foreach ($assets as $i => $asset)
                    <tr>
                        <td>
                            <input type="hidden" name="asset_id[]" value="{{$asset->asset_id}}">
                            <input type="hidden" name="type[]" value="{{$asset->type}}">
                            <input type="text" name="asset_name[]" value="{{old('asset_name.'.$i) ?? $asset->asset_name}}">
                            @error('asset_name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="name[]" list="user_names" value="{{old('name.'.$i) ?? $asset->name}}">
                            @error('name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="department_name[]" list="department_names" value="{{old('department_name.'.$i) ?? $asset->department_name}}">
                            @error('department_name.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>{{$asset->type}}</td>
                        @if ($type == 'ICT' || $type == 'All')
                            <td>
                                @if ($asset->type == 'ICT')
                                    <input type="text" name="brand[]" value="{{old('brand.'.$i) ?? $asset->brand}}" required>
                                    @error('brand.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'ICT')
                                    <input type="text" name="model[]" value="{{old('model.'.$i) ?? $asset->model}}" required>
                                    @error('model.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                        @endif
                        @if ($type == 'Computer Set' || $type == 'All')
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="processor[]" value="{{old('processor.'.$i) ?? $asset->processor}}" required>
                                    @error('processor.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="memory[]" value="{{old('memory.'.$i) ?? $asset->memory}}" required>
                                    @error('memory.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="video_card[]" value="{{old('video_card.'.$i) ?? $asset->video_card}}" required>
                                    @error('video_card.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="lan_card[]" value="{{old('lan_card.'.$i) ?? $asset->lan_card}}" required>
                                    @error('lan_card.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="sound_card[]" value="{{old('sound_card.'.$i) ?? $asset->sound_card}}" required>
                                    @error('sound_card.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="hard_drive[]" value="{{old('hard_drive.'.$i) ?? $asset->hard_drive}}" required>
                                    @error('hard_drive.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="optical_drive[]" value="{{old('optical_drive.'.$i) ?? $asset->optical_drive}}" required>
                                    @error('optical_drive.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="monitor[]" value="{{old('monitor.'.$i) ?? $asset->monitor}}" required>
                                    @error('monitor.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="mouse[]" value="{{old('mouse.'.$i) ?? $asset->mouse}}" required>
                                    @error('mouse.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="keyboard[]" value="{{old('keyboard.'.$i) ?? $asset->keyboard}}" required>
                                    @error('keyboard.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                            <td>
                                @if ($asset->type == 'Computer Set')
                                    <input type="text" name="avr[]" value="{{old('avr.'.$i) ?? $asset->avr}}" required>
                                    @error('avr.'.$i)
                                        {{$message}}
                                    @enderror
                                @endif
                            </td>
                        @endif
                        <td>
                            <input type="hidden" name="serviceable[{{$i}}]" value="0">
                            <input type="checkbox" name="serviceable[{{$i}}]" value="1" {{old('serviceable.'.$i) ? 'checked' : ($asset->serviceable ? 'checked' : '')}}>
                        </td>
                        <td>
                            <input type="date" name="precurement_date[]" value="{{old('precurement_date.'.$i) ?? $asset->precurement_date}}">
                            @error('precurement_date.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td>
                            <input type="file" name="asset_image[]" accept="image/*">
                            @error('asset_image.'.$i)
                                {{$message}}
                            @enderror
                        </td>
                        <td><input type="button" value="X" class="X btn btn-danger"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{route('admin.asset.index')}}" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-success" id = "btnUpdate" type="submit">Update</button>

    </form>

    
    <script>
        // if ('{{$asset->type}}' == 'ICT')
        //     $('.ICT').attr('type', 'hidden');
        // else
        //     $('.Computer-Set').attr('type', 'hidden');
        

        noRecordToEdit();
        
        $('#assetsTable').on('click', 'input.X', function() {
            $(this).parents('tr').remove();

            noRecordToEdit();
        });

        function noRecordToEdit() {
            if ($('#assetsTable tbody tr').length == 0) {
                $('#assetsTable tbody').html('<tr><td colspan="' + $('#assetsTable thead th').length + '" align="center">No records to edit.</td></tr>');
                $('#btnUpdate').attr('disabled', true);
            }
        }

    </script>

@endsection