<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UsersController as BackendUsersController;
use App\Http\Controllers\Backend\TemplateController as BackendTemplateController;
use Illuminate\Support\Facades\Route;

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

Route::get('backend', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('backend', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
//Route::get('/quick-search', [PagesController::class, 'quicksearch'])->name('quick-search');

Route::prefix('backend')->name('backend.')->middleware('auth:web')->group(function () {
  Route::group(['middleware' => ['role:super-admin|admin']], function () {
    Route::resource('users', BackendUsersController::class)->except(['show', 'edit', 'update']);
  });

  Route::prefix('users')->name('users.')->group(function () {
    Route::get('{id}/edit', [BackendUsersController::class, 'edit'])->name('edit');
    Route::put('{id}', [BackendUsersController::class, 'update'])->name('update');
    Route::post('resetpassword', [BackendUsersController::class, 'resetpassword'])->name('resetpassword');
    Route::post('changepassword', [BackendUsersController::class, 'changepassword'])->name('changepassword');
  });
  Route::resource('templates', BackendTemplateController::class);
});
