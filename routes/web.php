<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EducationController;
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
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('search/user', [SearchUserController::class, 'search'])->name('search-user');
    Route::post('user-permission-update/{id}', [UserController::class, 'updatePermission]'])->name('user-permission-update');

    Route::resource('user', UserController::class);
    Route::resource('education', EducationController::class);

    Route::post('/import-education', [EducationController::class, 'import'])->name('import-education');

    Route::controller(EducationController::class)->group(function () {
        Route::get('education/{id}/info', 'info')->name('education.info');
        Route::post('/info', 'saveInfo')->name('education.saveInfo');

        Route::get('education/{id}/diseases', 'diseases')->name('education.diseases');
        Route::post('/diseases', 'saveDiseases')->name('education.saveDiseases');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('getUsers', 'getUsers')->name('user.getUsers');
        Route::get('getTeachers', 'getTeachers')->name('user.getTeachers');
        Route::get('createTeacher', 'createTeacher')->name('teacher.create');
        Route::post('store', 'storeTeacher')->name('teacher.store');
    });
    Route::resource('role', RoleController::class);

    Route::controller(QuizController::class)->group(function () {
        Route::get('quiz', 'index')->name('quiz.index');
        Route::get('quiz/questions', 'questions')->name('quiz.questions');
        Route::post('quiz', 'store')->name('quiz.store');
        Route::post('activate', 'activate')->name('quiz.activate');
        Route::post('inactivate', 'inactivate')->name('quiz.inactivate');
        Route::get('/quiz/create', 'create')->name('quiz.create');
        Route::get('quiz/edit/{id}', 'edit')->name('quiz.edit');
        Route::post('quiz/edit/{id}', 'update');
        Route::delete('quiz/delete', 'destroy')->name('quiz.destroy');
    });
    Route::post('quiz/invite/{slug}', [\App\Http\Controllers\Backend\QuizShareController::class, 'invite'])->name('quiz.invite');

});
