
<a href="{{route('auth.logout')}}">Logout</a>
<a href="{{route('user.show', ['user' => $GLOBALS['user']->user_id])}}">Profile</a>

<button id="notif">notifications</button>
<div id="notifCount"></div>
<div id="notif_list"></div>

<script>
    var currentNotif = null,
        notification_list,
        notifSound = new Audio('{{asset("audios/notif.wav")}}');

        
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#notif').click(function(){
        $.ajax({
            url: '{{route("get_notification")}}',
            type: 'get',
            data: { 'data' : notification_list },
            success: function (data) 
            { 
                var html = '';

                $.each(notification_list.new_job_request, function(i, val){
                    var job = idExistInArrayObj(data, val, 'job_id');

                    if (job)
                        html += 'New Job request <br>'+ job.name +'<br>'+job.asset_name +'<br>' + job.priority+ '<hr>';
                    else
                        html += 'Data Deleted <hr>';
                });

                $.each(notification_list.verified_by_client, function(i, val){
                    var job = idExistInArrayObj(data, val, 'job_id');

                    if (job)
                        html += 'Verified By Client <br>'+ job.name +'<br>'+job.asset_name +'<br>' + job.priority+ '<hr>';
                    else
                        html += 'Data Deleted <hr>';
                });

                $('#notif_list').html(html);
            },
            error: function (){ }
        });
    });

    function idExistInArrayObj(arr, value, key){
        var result = null;

        $.each(arr, function(i, val){
            if (value == val[key]){
                result = val;
                return true;
            }
        });

        return result;
    }

    // setInterval(function(){
        $.ajax({
            url: '{{route("get_notification_count")}}',
            type: 'get',
            data: { },
            success: function (notifications) 
            { 
                notification_list = notifications;
                var newNotif = notifications.new_job_request.length + notifications.verified_by_client.length;
                if (newNotif != $('#notifCount').text())
                {
                    notification_list = notifications;
                    $('#notifCount').text(newNotif);
                }


                // console.log(data['new']);
                // if (currentNotif != data.data){
                //     currentNotif = data.data;
                //     if (currentNotif){
                //         if (!notifSound.paused)
                //             notifSound.pause();
                //         notifSound.play();
                //     }
                //     $('#notifCount').text(currentNotif);
                // }
            },
            error: function (){ }
        });
    // }, 1000);
    
</script>