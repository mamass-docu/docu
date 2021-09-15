@extends('layouts.admin.main')
@section('content')


    <style>
        @media print{
            *{
                visibility: hidden;
            }

            #qrcode * {
                visibility: visible;
            }
        }
    </style>
    
    <div id="qrcode" style="width:100px; height:100px;"></div>
    <button id="print_qr">Print Qr</button>

    <br>
    
    <form action="{{route('admin.asset.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="asset_id">QR Code Value</label>
        <input type="text" id="asset_id" value="{{$asset_id}}" disabled>
        <input type="hidden" name="asset_id" value="{{$asset_id}}">

        <br>

        <label for="type">Type</label>
        <select name="type" id="type">
            <option value="ICT">ICT</option>
            <option value="Computer Set" {{old('type') == 'Computer Set' ? 'selected' : ''}}>Computer Set</option>
        </select>

        <br>

        <label for="name">Name</label>
        <input type="text" name="asset_name" value="{{old('asset_name')}}">
        @error('asset_name')
            {{$message}}
        @enderror

        <br>

        <label for="name">Person-in-charge</label>
        <input type="text" list="name" name="name" value="{{old('name')}}">
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
        <input type="text" list="department_name" name="department_name" value="{{old('department_name')}}">
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
            <input type="text" name="brand" value="{{old('brand')}}">
            @error('brand')
                {{$message}}
            @enderror

            <br>

            <label for="model">Model</label>
            <input type="text" name="model" value="{{old('model')}}">
            @error('model')
                {{$message}}
            @enderror

            <br>
        </div>

        <div id="Computer_Set_part" style="display: none">
            <label for="processor">Processor</label>
            <input type="text" name="processor" value="{{old('processor')}}">
            @error('processor')
                {{$message}}
            @enderror

            <br>

            <label for="memory">Memory</label>
            <input type="text" name="memory" value="{{old('memory')}}">
            @error('memory')
                {{$message}}
            @enderror

            <br>

            <label for="video_card">Video Card</label>
            <input type="text" name="video_card" value="{{old('video_card')}}">
            @error('video_card')
                {{$message}}
            @enderror

            <br>

            <label for="lan_card">LAN Card</label>
            <input type="text" name="lan_card" value="{{old('lan_card')}}">
            @error('lan_card')
                {{$message}}
            @enderror

            <br>

            <label for="sound_card">Sound Card</label>
            <input type="text" name="sound_card" value="{{old('sound_card')}}">
            @error('sound_card')
                {{$message}}
            @enderror

            <br>

            <label for="hard_drive">Hard Drive</label>
            <input type="text" name="hard_drive" value="{{old('hard_drive')}}">
            @error('hard_drive')
                {{$message}}
            @enderror

            <br>

            <label for="optical_drive">Optical Drive</label>
            <input type="text" name="optical_drive" value="{{old('optical_drive')}}">
            @error('optical_drive')
                {{$message}}
            @enderror

            <br>

            <label for="monitor">Monitor</label>
            <input type="text" name="monitor" value="{{old('monitor')}}">
            @error('monitor')
                {{$message}}
            @enderror

            <br>

            <label for="mouse">Mouse</label>
            <input type="text" name="mouse" value="{{old('mouse')}}">
            @error('mouse')
                {{$message}}
            @enderror

            <br>

            <label for="keyboard">Keyboard</label>
            <input type="text" name="keyboard" value="{{old('keyboard')}}">
            @error('keyboard')
                {{$message}}
            @enderror

            <br>

            <label for="avr">AVR</label>
            <input type="text" name="avr" value="{{old('avr')}}">
            @error('avr')
                {{$message}}
            @enderror

            <br>
        </div>

        <input type="hidden" name="serviceable" value="0">
        <input type="checkbox" name="serviceable" value="1" {{old('serviceable') ? 'checked' : ''}}>
        <label for="serviceable">Serviceable</label>

        <br>

        <label for="precurement_date">Precurement Date</label>
        <input type="date" name="precurement_date" value="{{old('precurement_date')}}">
        @error('precurement_date')
            {{$message}}
        @enderror

            <br>

        <input type="file" name="asset_image">

        <button type="submit">Save</button>
    </form>

    
    <script src="{{asset('vendor/qrcode-generator/qrcode.js')}}"></script>
    
    <script> 
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 100,
            height: 100
        });

        qrcode.makeCode($('#asset_id').val());

        if ('{{old("type")}}' == 'Computer Set')
            resetICTVal();


        $('#print_qr').click(function(){
            window.print();
        });

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