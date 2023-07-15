<?php

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
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController ;
use App\Http\Controllers\CourrierController;

 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AuthController::class,'getLogin'])->name('getLogin'
);

Route::post('/admin/login', [AuthController::class,'postLogin'])->name('postLogin'
);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/send-courrier/logout', [CourrierController::class, 'logout'])->name('logout');
Route::get('/sendcourrier', [CourrierController::class, 'showSendCourrierForm'])->name('sendcourrier');
Route::post('/send-courrier', [CourrierController::class, 'sendCourrier'])->name('courrier.send');
Route::get('/inbox', [CourrierController::class, 'inbox'])->name('inbox');
Route::delete('/messages/delete', [CourrierController::class, 'deleteMessages'])->name('deleteMessages');
Route::get('/mailbox/search', [CourrierController::class, 'search'])->name('mailbox.search');






