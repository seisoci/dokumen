<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\TemplateController;
use App\Http\Controllers\Backend\DocumentController;
use App\Http\Controllers\Backend\TemplateFormController;
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

Route::middleware('auth:web')->group(function () {
  Route::group(['middleware' => ['role:super-admin|admin']], function () {
    Route::resource('users', UsersController::class)->except(['show', 'edit', 'update']);
  });

  Route::prefix('users')->name('users.')->group(function () {
    Route::get('{id}/edit', [UsersController::class, 'edit'])->name('edit');
    Route::put('{id}', [UsersController::class, 'update'])->name('update');
    Route::post('resetpassword', [UsersController::class, 'resetpassword'])->name('resetpassword');
    Route::post('changepassword', [UsersController::class, 'changepassword'])->name('changepassword');
  });
  Route::resource('templates', TemplateController::class);
  Route::resource('documents', DocumentController::class);
  Route::post('templateforms/{id}/changehierarchy', [TemplateFormController::class, 'change_hierarchy'])->name('change_hierarchy');
  Route::resource('templateforms', TemplateFormController::class);
});
