<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function(){

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'profile_update'])->name('profile.update');


    Route::get('/manager', [AdminController::class, 'manager'])->name('manager');
    Route::post('/manager', [AdminController::class, 'project_store'])->name('project.store');
    Route::post('/manager/edit/{id}', [AdminController::class,'project_update'])->name('project.update');
    Route::post('/manager/delete/{id}', [AdminController::class, 'project_destroy'])->name('project.delete');

    Route::get('/step1', [UserController::class, 'step1view'])->name('step1.view');
    Route::post('/step1', [UserController::class, 'step1store'])->name('step1.store');

    Route::get('/step2', [UserController::class, 'step2view'])->name('step2.view');
    Route::post('/step2', [UserController::class, 'step2store'])->name('step2.store');

    Route::get('/step3', [UserController::class, 'step3view'])->name('step3.view');
    Route::post('/step3', [UserController::class, 'step3store'])->name('step3.store');

    Route::get('/step4', [UserController::class, 'step4view'])->name('step4.view');
    Route::post('/step4', [UserController::class, 'step4store'])->name('step4.store');

    //step 5
    Route::get('/projects', [UserController::class, 'projects'])->name('projects');
    Route::post('/projects', [UserController::class, 'projects_store'])->name('projects.store');

    Route::get('/complete', [UserController::class, 'complete'])->name('complete');

    Route::post('/profile/password', [UserController::class, 'profile_password'])->name('profile.password');
    Route::post('/profile/interest', [UserController::class, 'profile_interest'])->name('profile.interest');
    Route::get('/profile/delete', [UserController::class, 'profile_delete'])->name('profile.delete');

    Route::get('/user/create', [AdminController::class, 'user_create'])->name('user.create');
    Route::post('/users/create', [AdminController::class,'user_store'])->name('user.store');

    Route::get ('/users/view/{id}', [AdminController::class,'user'])->name('admin.user');
    Route::get('/user/attention/{id}', [AdminController::class, 'user_activate_attention'])->name('activate.attention');
    Route::get('/user/delete/{id}', [AdminController::class, 'user_destroy'])->name('user.delete');
    Route::post('/users/edit/{id}', [AdminController::class,'user_update'])->name('user.update');
    Route::post('/users/notes/{id}', [AdminController::class,'user_update_notes'])->name('user.update.notes');
    Route::post('/users/update/{id}', [AdminController::class,'user_update_other'])->name('user.update.other');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/api/users', [AdminController::class,'users_datatable'])->name('api.users');

    Route::get('/', [UserController::class, 'router'])->name('home');
    Route::get('/home', [UserController::class, 'router'])->name('hometoo');
});

Route::get('/register', [UserController::class, 'registration'])->name('register');
Route::post('/register', [UserController::class, 'create'])->name('register');
Route::get('/thanks', [UserController::class, 'postregister'])->name('verification.notice');
Route::get('/deleted', [UserController::class, 'deleted_profile'])->name('profile.deleted');
#Route::get('/test', [AdminController::class, 'test'])->name('test');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Is cache clear?";
});
