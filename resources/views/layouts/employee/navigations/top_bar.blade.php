
<a href="{{route('auth.logout')}}">Logout</a>
<a href="{{route('user.show', ['user' => $GLOBALS['user']->user_id])}}">Profile</a>

<button id="notif">notifications</button>
<div id="notifCount"></div>
<div id="notif_list"></div>

<script>
    var currentNotif = null,
        notifInterval,
        notif_list,
        notifSound = new Audio('{{asset("audios/notif.wav")}}');


    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#notif').click(function(){
        var jobs = notif_list;
        clearInterval(notifInterval);

        $.ajax({
            url: '{{route("get_notification")}}',
            type: 'get',
            data: {},
            success: function (data) 
            { 
                var html = '';
                console.log(notif_list);
                console.log(data)
                $.each(jobs.job_request_progress, function(i, val){
                    var job = idExistInArrayObj(data, val, 'job_id');

                    if (job)
                        html += 'Job Progress <br>'+ job.name +'<br>'+job.asset_name +'<br>' + job.priority+ '<hr>';
                    else
                        html += 'Data Deleted <hr>';
                });

                $.each(jobs.job_request_to_verify, function(i, val){
                    var job = idExistInArrayObj(data, val, 'job_id');

                    if (job)
                        html += 'Done Job <br>'+ job.name +'<br>'+job.asset_name +'<br>' + job.priority+ '<hr>';
                    else
                        html += 'Data Deleted <hr>';
                });

                $('#notif_list').html(html);
                $('#notifCount').text('');
            },
            error: function (){ }
        });
    });

    notif_interval();

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

    function notif_interval(){   
        notifInterval = setInterval(function(){
            $.ajax({
                url: '{{route("get_notification_count")}}',
                type: 'get',
                data: { },
                success: function (notifications) 
                { 
            console.log(1)
                    var newNotif = notifications.job_request_progress.length + notifications.job_request_to_verify.length;
                    
                    if (newNotif != $('#notifCount').text() && newNotif > 0)
                    {
                        notif_list = notifications;
                        $('#notifCount').text(newNotif);
                        if (!notifSound.paused)
                            notifSound.pause();
                        notifSound.play();
                    }
                },
                error: function (){ }
            });
        }, 1000);
    }

</script>