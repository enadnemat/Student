@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center">
        <div class="mt-5">
            <div class="card" style="width: 18rem">
                <div class="card-header">
                    Other Students
                </div>
            <ul class="list-group ">
                @foreach($users as $user)
                    <a href="{{route('user.chats',$user->id)}}" class=" @if(request('user_id') == $user->id) active @endif user list-group-item px-5 ">
                        <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png"
                             width="30"
                             height="30" alt="pic"> {{$user->username}}
                    </a>
                @endforeach
            </ul>
            </div>
        </div>
        <div class="card mt-5 w-75 ">
            <div class="d-flex flex-row justify-content-center pt-3 adiv text-white border border-bottom-dark">
                <span class="pb-3 text-black" id="user_name">Live Chat with {{ $receiver->username }}</span>
            </div>
            <div id="chat_area" class="overflow-x-scroll" style="height: 100vh">
                @foreach($messages as $message)

                    <div class="d-flex flex-row-reverse p-3 w-100">

                        @if(Auth::user()->id == $message->sender)
                            <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png"
                                 width="30"
                                 height="30" alt="pic">
                            <div class="chat ml-2 p-3 bg-primary text-white justify-content-end w-100">
                                {{$message->message}}
                            </div>
                        @else
                            <div
                                class="chat ml-2 p-3 w-100 @if(Auth::user()->id == $message->receiver)bg-white @else bg-primary text-white @endif text-break   ">
                                {{$message->message}}
                            </div>
                            <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png"
                                 width="30"
                                 height="30" alt="pic">

                        @endif
                    </div>
                @endforeach
            </div>

            <div class="my-3 mx-2 flex-column">
                <input class="form-control" type="text" name="message" id="message" required>
                <input type="submit" value="Send" id="send" class="btn btn-primary mt-3">
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        $("#send").click(function () {
            var message = $('#message').val();
            $.ajax({
                url: "{{route('sendMessage',$receiver->id)}}",
                type: 'post',
                data: {message: message,},
                dataType: 'json',
                success: function (data, textStatus) {
                    console.log("Data " + data + "\nstatus " + textStatus)
                    let senderMessage = '' +
                        '<div class="d-flex flex-row p-3"><div class="chat ml-2 p-3 bg-primary text-white justify-content-end w-100">' + $("#message").val() + '</div>' +
                        '<img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="30" ' +
                        '  height="30" alt="pic">' +
                        '</div>';

                    $("#message").val('');
                    $("#chat_area").append(senderMessage);
                }
            })
        })

        // Pusher.logToConsole = true;

        var pusher = new Pusher('1004b3fee028c17544fc', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('chat{{Auth::user()->id}}');
        channel.bind('chatMessage', function (data) {
            let receiverMessage = '<img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png"' +
                ' width="30" height="30" alt="pic">' +
                '<div class="chat ml-2 p-3 bg-white text-break ">' + data.message + '</div>';
            $("#chat_area").append(receiverMessage);
        });

    </script>
@endsection
