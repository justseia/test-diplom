<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SearchUserController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(QuizController::class)->group(function () {
    Route::get('quiz', 'index')->name('quiz');
    Route::get('quiz/accept/{slug}/{token}', 'accept')->name('quiz.accept');
    Route::post('quiz/accept/{slug}/{token}', 'answer');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('search/user', [SearchUserController::class, 'search'])->name('search-user');
    Route::post('user-permission-update/{id}', [UserController::class, 'updatePermission]'])->name('user-permission-update');

    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    Route::controller(QuizController::class)->group(function (){
        Route::get('quiz', 'index')->name('quiz.index');
        Route::post('quiz', 'store');
        Route::get('quiz/edit/{slug}', 'edit')->name('quiz.edit');
        Route::post('quiz/edit/{slug}', 'update');
        Route::delete('quiz/delete', 'destroy')->name('quiz.destroy');
        Route::post('quiz/invite/{slug}', 'invite')->name('quiz.invite');
    });

});
