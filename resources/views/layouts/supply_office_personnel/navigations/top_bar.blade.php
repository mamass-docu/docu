
<a href="{{route('auth.logout')}}">Logout</a>
<a href="{{route('user.show', ['user' => User()->user_id])}}">Profile</a>

<div id="notifCount"></div>

<script>
    var currentNotif = 0,
        notifSound = new Audio('{{asset("audios/notif.wav")}}');

    // setInterval(function(){
    //     $.ajaxSetup({
    //         headers: {
    //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         url: '{{route("admin.notif")}}',
    //         type: 'get',
    //         data: { },
    //         success: function (data) 
    //         {  
    //             if (currentNotif != data.data){
    //                 currentNotif = data.data;
    //                 if (currentNotif){
    //                     if (!notifSound.paused)
    //                         notifSound.pause();
    //                     notifSound.play();
    //                 }
    //                 $('#notifCount').text(currentNotif);
    //             }
    //         },
    //         error: function (){ }
    //     });
    // }, 1000);
    
</script>