<?php

namespace App\Services;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\User;
use App\Models\UserSubject;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUser($user_id)
    {
        return User::find($user_id);
    }

    public function getUserColleague()
    {
        $user_id = Auth::user()->id;
        $subjects = UserSubject::select('subject_id')->where('user_id', $user_id)->get();
        $subjects_id = array();

        foreach ($subjects as $subject) {
            $subjects_id[] = $subject['subject_id'];
        }

        $users = UserSubject::select('user_id')->whereIn('subject_id', $subjects_id)->where('user_id', '!=', $user_id)->get();
        $users_id = array();
        foreach ($users as $user) {
            $users_id[] = $user['user_id'];
        }
        return User::select('id', 'username', 'email')->whereIn('id', $users_id)->where('is_active', 1)->get();
    }


    public function sendMessage($user_id, $message)
    {
        Message::create([
            'sender' => Auth::user()->id,
            'receiver' => $user_id,
            'message' => $message,
        ]);
        $reveiver = $this->getUser($user_id);
        \Broadcast(new ChatSent($reveiver, $message));
    }
}
