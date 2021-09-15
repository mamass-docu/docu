<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MinSU Asset Management and Support System</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    

</head>

<body>

    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('css/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <div class="container-fluid">
        @include('layouts.admin.navigations.top_bar')
        @if (session('success'))
            {{session('success')}}
        @endif
        @if (session('error'))
            {{session('error')}}
        @endif

        @yield('content')
    </div>

</body>
</html>