<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/check', function () {
    return Auth::user() ?? "false";
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'chat'], function () {
    Route::get('/{user_id}', [\App\Http\Controllers\ChatsController::class, 'index'])->name('user.chats')->middleware('auth');
    Route::post('/{user_id}', [\App\Http\Controllers\ChatsController::class, 'sendMessage'])->name('sendMessage')->middleware('auth');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', [AdminController::class, 'login'])->name('admin.loginPage');
    Route::post('postLogin', [AdminController::class, 'postLogin'])->name('admin.login');
    Route::post('logout', [AdminController::class, 'Logout'])->name('admin.logout');


    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/tables', [AdminController::class, 'getTables'])->name('admin.tables');
        Route::post('/getUserData', [AdminController::class, 'GetUserData'])->name('getUserData');
        Route::post('/updateUserData', [AdminController::class, 'UpdateUserData'])->name('updateUserData');

        Route::post('user/delete', [AdminController::class, 'DeleteUser'])->name('user.delete');

        Route::post('registerUser', [AdminController::class, 'RegisterUser'])->name('admin.create.user');
        Route::post('createSubject', [AdminController::class, 'CreateSubject'])->name('admin.create.subject');
        Route::post('assignSubject', [AdminController::class, 'AssignSubject'])->name('admin.assignSubject');
        Route::post('getSubjects', [AdminController::class, 'GetSubjects'])->name('admin.getSubjects');
        Route::post('getUserSubjects', [AdminController::class, 'GetUserSubjects'])->name('admin.getUserSubjects');
        Route::post('getMark', [AdminController::class, 'GetMark'])->name('admin.getMark');
        Route::post('updateMark', [AdminController::class, 'UpdateMark'])->name('admin.updateMark');

        Route::post('checkUsername', [AdminController::class, 'CheckUsername'])->name('checkUsername');


    });
});
