<!doctype html>
<html lang="en">
    <head>
    <title>Chat</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row mt-3">
                <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-header">
                            Chat Room
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Name">
                            </div>
                            <div class="form-group" id="data-message">
                                
                            </div>
                            <div class="form-group">
                                <textarea id="message" cols="30" rows="10" class="form-control" placeholder="Message..."></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{url('../js/app.js')}}"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const http = window.axios;
            const Echo = window.Echo;
            const name = $("#name");
            const message = $("#message");

            $("input, textarea").keyup(function(){
                $(this).removeClass('is-invalid')
            });

            $('button').click(function(){
                if(name.val() == ''){
                    name.addClass('is-invalid');
                } else if(message.val == ''){
                    message.addClass('is-invalid');
                } else {
                    $.post("{{url('send')}}", {
                        'name': name.val(),
                        'message': message.val()
                    }).then(()=>{
                        message.val('');
                    });
                }
            });
            let channel = Echo.channel('channel-chat');
            var x = pusher.subscribe("my-channel");
            channel.listen('ChatEvent', (data)=>{
                // $("#data-message")
                // .append(`<strong>${data.message.name}</strong>`);
                console.log(x);
            });
        })
    </script>
</body>
</html>