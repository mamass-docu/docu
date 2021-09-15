@extends('layouts.admin.main')
@section('content')
  
    <h1>Profile</h1>

    <form action="{{route('user.update', ['user'=>$GLOBALS['user']->user_id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <input src={{asset('images/users/'.$GLOBALS['user']->image_name)}} type="file" accept="image/*" name = 'image'> <br>
        @error('image') {{$message}} @enderror

        <label for="name">Name</label>
        <input value="{{old('name') ?? $GLOBALS['user']->name}}" type="text" name="name"><br>
        @error('name') {{$message}} @enderror
        
        <label for="email">Email</label>
        <input value="{{old('email') ?? $GLOBALS['user']->email}}" type="text" name="email"><br>
        @error('email') {{$message}} @enderror
        
        {{-- <label for="department_name">Department</label>
        <input value="{{old('department_name') ?? $GLOBALS['user']->}}" type="text" name="department_name"><br>
        @error('department_name') {{$message}} @enderror --}}

        <button type="submit">Save</button>
    </form> 
    <br> <br>

    <form action="{{route('user.update_password', ['user'=>$GLOBALS['user']->user_id])}}" method="post">
        @csrf
        @method('put')

        <label for="user_current_password">Current Password</label>
        <input type="password" name = 'user_current_password'><br>
        @error('user_current_password') {{$message}} @enderror

        <label for="user_new_password">New Password</label>
        <input type="password" name="user_new_password"> <br>
        @error('user_new_password') {{$message}} @enderror
        
        <label for="user_confirm_new_password">Confirm Password</label>
        <input type="password" name="user_confirm_new_password"><br>
        @error('user_confirm_new_password') {{$message}} @enderror
        
        <button type="submit">Save</button>
    </form>
    
    <br><br>

    <form action="{{route('user.loggout_all_other_sessions', ['user'=>$GLOBALS['user']->user_id])}}" method="post">
        @csrf
        @method('put')

        @foreach ($login_sessions as $item)
            {{$item->device}} - {{$item->browser}} <br>
            {{$item->ip_address}} 
            @if (cache($item->login_information_id.'-is-active') )
                Online <br><br>
            @else
                Offline <br><br>
            @endif
        @endforeach

        {{$GLOBALS['login-info']->device}} - 
        {{$GLOBALS['login-info']->browser}} <br>
        {{$GLOBALS['login-info']->ip_address}} This Device <br><br>

        <button type="submit">Logout All Other Sessions</button>
    </form>

    <br>

    <form action="{{route('user.destroy', ['user'=>$GLOBALS['user']->user_id])}}" method="post">
        @csrf
        @method('delete')

        <button type="submit">Delete Account</button>
    </form>

    
@endsection