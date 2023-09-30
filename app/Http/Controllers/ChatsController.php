<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($user_id, UserService $userService)
    {
        $users = $userService->getUserColleague();
        if ($user_id == null) {
            $receiver = $users->first();
        } else {
            $receiver = User::find($user_id);
        }
        $messages = Message::whereIn('sender', [Auth::user()->id, $user_id])->whereIn('receiver', [$user_id, Auth::user()->id])->get();
        //return $messages;
        return view('chat', compact('users', 'receiver', 'messages'));
    }

    public function sendMessage($user_id, UserService $userService, Request $request)
    {
        //return $request->message;
        $userService->sendMessage($user_id, $request->message);

        return true;
    }

}
