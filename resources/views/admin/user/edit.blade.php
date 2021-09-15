@extends('layouts.admin.main')
@section('content')


    <form action="{{route('user.update', ['user'=>$user->user_id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        
        <input src={{asset('images/users/'.$user->image_name)}} type="file" accept="image/*" name = 'image'> <br>
        @error('image') {{$message}} @enderror

        <label for="name">Name</label>
        <input value="{{old('name') ?? $user->name}}" type="text" name="name"><br>
        @error('name') {{$message}} @enderror
        
        <label for="email">Email</label>
        <input value="{{old('email') ?? $user->email}}" type="text" name="email"><br>
        @error('email') {{$message}} @enderror
        
        <label for="department_name">Department</label>
        <input value="{{old('department_name') ?? $user->department_name}}" type="text" name="department_name"><br>
        @error('department_name') {{$message}} @enderror

        <button type="submit">Save</button>

    </form>


    
    <script>

        


        $('#p').click(function(){
        });
    </script>

@endsection