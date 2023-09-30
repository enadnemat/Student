<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(UserService $userService)
    {
        $users = $userService->getUserColleague()->first();
        $user = User::where('id', '=', \Auth::user()->id)->with('subjects')->get();

        return view('home', compact('user', 'users'));
    }
}
