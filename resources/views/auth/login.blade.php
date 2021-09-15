@extends('layouts.auth.main')
@section('content')
    

    @if (session('error'))
        {{session('error')}}
    @endif


    @if (cache(UserTool::getKey().'-not-allowed') )
        Too many attempts try again in
        {{ cache(UserTool::getKey().'-not-allowed') }}
    @endif

    <form action="{{route('auth.login')}}" method="POST">
        @csrf

        email: <input type="text" name="email" value="{{old('email')}}"><br>
        @error('email')
            {{$message}} <br>
        @enderror
        password: <input type="password" name="password"><br>
        @error('password')
            {{$message}} <br>
        @enderror
        <input type="checkbox" name="remember" id=""> remember <br>
        <button type="submit">Login</button>
    </form>

@endsection