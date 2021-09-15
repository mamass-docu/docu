@extends('layouts.admin.main')
@section('content')


    <label for="asset_id">QR Code Value</label>
    <input type="text" name="asset_id" id="asset_id" value="{{$asset->asset_id}}" disabled>

    <br>

    <form action="{{route('admin.asset.update', ['asset' => $asset->asset_id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <input type="hidden" name="type" value="{{$asset->type}}">

        <br>

        <label for="name">Name</label>
        <input type="text" name="asset_name" value="{{old('asset_name') ?? $asset->asset_name}}">
        @error('asset_name')
            {{$message}}
        @enderror

        <br>

        <label for="name">Person-in-charge</label>
        <input type="text" list="name" name="name" value="{{old('name') ?? $asset->name}}">
        <datalist name="" id="name">
            @foreach ($users as $user)
                <option value="{{$user->name}}">
            @endforeach
        </datalist>
        @error('name')
            {{$message}}
        @enderror

        <br>

        <label for="department_name">Office</label>
        <input type="text" list="department_name" name="department_name" value="{{old('department_name') ?? $asset->department_name}}">
        <datalist name="" id="department_name">
            @foreach ($departments as $department)
                <option value="{{$department->department_name}}">
            @endforeach
        </datalist>
        @error('department_name')
            {{$message}}
        @enderror

        <br>

        <div id="ICT_part">
            <label for="brand">Brand</label>
            <input type="text" name="brand" value="{{old('brand') ?? $asset->brand}}">
            @error('brand')
                {{$message}}
            @enderror

        <br>

            <label for="model">Model</label>
            <input type="text" name="model" value="{{old('model') ?? $asset->model}}">
            @error('model')
                {{$message}}
            @enderror

        <br>
        </div>

        <div id="Computer_Set_part" style="display: none">
            <label for="processor">Processor</label>
            <input type="text" name="processor" value="{{old('processor') ?? $asset->processor}}">
            @error('processor')
                {{$message}}
            @enderror

        <br>

            <label for="memory">Memory</label>
            <input type="text" name="memory" value="{{old('memory') ?? $asset->memory}}">
            @error('memory')
                {{$message}}
            @enderror

        <br>

            <label for="video_card">Video Card</label>
            <input type="text" name="video_card" value="{{old('video_card') ?? $asset->video_card}}">
            @error('video_card')
                {{$message}}
            @enderror

        <br>

            <label for="lan_card">LAN Card</label>
            <input type="text" name="lan_card" value="{{old('lan_card') ?? $asset->lan_card}}">
            @error('lan_card')
                {{$message}}
            @enderror

        <br>

            <label for="sound_card">Sound Card</label>
            <input type="text" name="sound_card" value="{{old('sound_card') ?? $asset->sound_card}}">
            @error('sound_card')
                {{$message}}
            @enderror

        <br>

            <label for="hard_drive">Hard Drive</label>
            <input type="text" name="hard_drive" value="{{old('hard_drive') ?? $asset->hard_drive}}">
            @error('hard_drive')
                {{$message}}
            @enderror

        <br>

            <label for="optical_drive">Optical Drive</label>
            <input type="text" name="optical_drive" value="{{old('optical_drive') ?? $asset->optical_drive}}">
            @error('optical_drive')
                {{$message}}
            @enderror

        <br>

            <label for="monitor">Monitor</label>
            <input type="text" name="monitor" value="{{old('monitor') ?? $asset->monitor}}">
            @error('monitor')
                {{$message}}
            @enderror

        <br>

            <label for="mouse">Mouse</label>
            <input type="text" name="mouse" value="{{old('mouse') ?? $asset->mouse}}">
            @error('mouse')
                {{$message}}
            @enderror

        <br>

            <label for="keyboard">Keyboard</label>
            <input type="text" name="keyboard" value="{{old('keyboard') ?? $asset->keyboard}}">
            @error('keyboard')
                {{$message}}
            @enderror

        <br>

            <label for="avr">AVR</label>
            <input type="text" name="avr" value="{{old('avr') ?? $asset->avr}}">
            @error('avr')
                {{$message}}
            @enderror

        <br>
        </div>

        <input type="hidden" name="serviceable" value="0">
        @if (old('serviceable') == '1')
            <input type="checkbox" name="serviceable" value="1" checked>
        @elseif($asset->serviceable == '1' && !old('serviceable') )
            <input type="checkbox" name="serviceable" value="1" checked>
        @else
            <input type="checkbox" name="serviceable" value="1">
        @endif
        <label for="serviceable">Serviceable</label>

        <br>

        <label for="precurement_date">Precurement Date</label>
        <input type="date" name="precurement_date" value="{{old('precurement_date') ?? $asset->precurement_date}}">
        @error('precurement_date')
            {{$message}}
        @enderror

        <br>

        <input type="file" name="asset_image">

        <button type="submit">Save</button>
    </form>

    
    
    <script> 
        if ('{{$asset->type}}' == 'Computer Set')
            resetICTVal();

        $('#type').on('change', function(){
            if ($('#type :selected').text() == 'ICT')
                resetComputerSetVal();
            else
                resetICTVal();
        });

        function resetICTVal(){
            $('#ICT_part input').each(function(){
                $(this).val(null);
            });
            $('#ICT_part').hide();
            $('#Computer_Set_part').show();
        }

        function resetComputerSetVal(){
            $('#Computer_Set_part input').each(function(){
                $(this).val(null);
            });
            $('#ICT_part').show();
            $('#Computer_Set_part').hide();
        }
    </script>

@endsection