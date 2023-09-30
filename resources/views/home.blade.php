@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(Auth::user()->is_active == 0 )
                        <div class="card-header">Dashboard</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            The account is inactive, please wait for the administrator to activate your account.
                        </div>
                    @else
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            Your account is active, Enjoy!
                        </div>
                    @endif

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>{{Auth::user()->username}}</td>
                            <td>{{Auth::user()->email}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                @if(Auth::user()->is_active == 1)
                    <table class="table text-center mt-5 border border-1 mb-3">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Pass Mark</th>
                            <th>Your Mark</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($user->flatMap->subjects as $subject)
                            <tr>
                                <td>{{$subject->name ?? "Subject Name"}}</td>
                                <td>{{$subject->pass_mark ?? "Subject Pass Mark"}}</td>
                                <td>{{$subject->pivot->mark ?? 0}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="text-center mt-3">
                    Feel free to chat with one of your colleague.
                    <a href="{{route('user.chats',$users->id)}}" type="button" class="btn btn-info">Got to chat area</a>
                </div>
            </div>
        </div>
    </div>
@endsection
