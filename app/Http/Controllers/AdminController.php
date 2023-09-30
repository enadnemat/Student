<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserSubject;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use mysql_xdevapi\Exception;

class AdminController extends Controller
{
    public function index()
    {
        $users_count = User::all()->count();

        $subjects_count = Subject::all()->count();

        return view('admin.index', compact('subjects_count', 'users_count'));
    }

    public function Login()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            return redirect()->route('admin.index');
        }
        return back()->with('error', 'Invalid Credential');

    }

    public function Logout()
    {
        \Session::flush();

        Auth::guard('admin')->logout();

        return redirect()->route('admin.loginPage');
    }

    public function getTables(Request $request)
    {


        if ($request->ajax() | 0) {

            $users = User::all();
            return Datatables($users)
                ->setRowId('id')
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Update Button
                    $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='" . $row->id . "' data-bs-toggle='modal' data-bs-target='#updateModal' >Edit</button>";

                    // Delete Button
                    $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='" . $row->id . "' data-bs-toggle='modal' data-bs-target='#deleteModal'>Delete</button>";

                    return $updateButton . " " . $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);

        } else {
            $users = User::all();
            $subjects = Subject::all();
            return view('admin.table', compact('users', 'subjects'));
        }
    }

    public function GetUserData(Request $request)
    {
        $id = $request->post('id');
        $user = User::find($id);

        $response = array();

        if (!empty($user)) {
            $response['username'] = $user->username;
            $response['email'] = $user->email;
            $response['is_active'] = $user->is_active;

            $response['success'] = 1;
        } else {
            $response['success'] = 0;
        }

        return response()->json($response);
    }

    public function UpdateUserData(Request $request)
    {
        $id = $request->post('id');

        $user = User::find($id);

        $response = array();
        if (!empty($user)) {
            $new_data['username'] = $request->post('username');
            $new_data['email'] = $request->post('email');
            $new_data['is_active'] = $request->post('is_active');

            if ($user->update($new_data)) {
                $response['success'] = 1;
                $response['msg'] = 'Update successfully';
            } else {
                $response['success'] = 0;
                $response['msg'] = 'Record not updated';
            }

        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }

        return response()->json($response);

    }

    public function RegisterUser(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'is_active' => 'required',
            ]);

            $data = $request->only('username', 'email', 'password', 'is_active');

            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => $data['is_active'],
            ]);


        } catch (\Throwable $e) {
            report($e);

            return false;
        }


    }

    public function CheckUsername(Request $request)
    {
        $data = $request->only('username');
        $user = User::where('username', '=', $data['username'])->first();

        if (!$user) {
            return response()->json(true);
        } else {
            return 0;
        }

    }

    public function DeleteUser(Request $request)
    {
        $id = $request->post('id');

        $user = User::find($id);

        $user->delete();

    }

    public function CreateSubject(Request $request)
    {
        $data = $request->only('name', 'pass_mark', 'obtained_mark');
        $subject = Subject::create([
            'name' => $data['name'],
            'pass_mark' => $data['pass_mark'],
            'obtained_mark' => $data['obtained_mark'],
        ]);
    }

    public function AssignSubject(Request $request)
    {
        $data = $request->only('user_id', 'subject_id');
        $user_id = $data['user_id'];
        $subject_id = $data['subject_id'];

        //return $data;
        UserSubject::create([
            'user_id' => $user_id,
            'subject_id' => $subject_id,
        ]);
    }

    public function GetSubjects(Request $request)
    {
        $user_id = $request->post('user_id');

        $user_subjects = UserSubject::select('subject_id')->where('user_id', '=', $user_id)->get();
        $subject_ids = array();
        foreach ($user_subjects as $subject) {
            array_push($subject_ids, $subject['subject_id']);
        }
        $subjects = Subject::select('id', 'name')->whereNotIn('id', $subject_ids)->get();

        return $subjects;
    }

    public function GetUserSubjects(Request $request)
    {
        $user_id = $request->post('user_id');
        $user_subjects = UserSubject::select('subject_id')->where('user_id', '=', $user_id)->get();
        $subject_ids = array();
        foreach ($user_subjects as $subject) {
            array_push($subject_ids, $subject['subject_id']);
        }
        $subjects = Subject::select('id', 'name')->whereIn('id', $subject_ids)->get();

        return $subjects;

    }

    public function GetMark(Request $request)
    {
        $user_id = $request->post('user_id');
        $subject_id = $request->post('subject_id');
        //return $user_id;
        $mark = UserSubject::select('mark')
            ->where('user_id', '=', $user_id)
            ->where('subject_id', '=', $subject_id)
            ->first();

        return $mark;
    }

    public function UpdateMark(Request $request)
    {

        //return $request;
        $user_id = $request->post('id_user');
        $subject_id = $request->post('id_subject');
        $mark = $request->post('mark');

        $record = \DB::table('user_subject')
            ->where('user_id', '=', $user_id)
            ->where('subject_id', '=', $subject_id)
            ->update([
                'mark' => $mark,
            ]);
    }

}
