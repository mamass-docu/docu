@extends('layouts.admin.main')
@section('content')

    <div id="main">
        <button class="btn btn-info">test</button>
        <td>test</td>
    </div>

    <script>
        $('body button').on('mouseup', function(){
            console.log(1)
        });
    </script>

@endsection