<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\TemplateController;
use App\Http\Controllers\Backend\TemplateFormController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DocumentController;
use App\Http\Controllers\Backend\GenerateController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
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
  Route::get('dashboard', DashboardController::class);
  Route::resource('templates', TemplateController::class);
  Route::get('documents/{idTemplate}/create', [DocumentController::class, 'create'])->name('documents.create');
  Route::post('documents/{idTemplate}', [DocumentController::class, 'store'])->name('documents.store');
  Route::put('documents/{idTemplate}/', [DocumentController::class, 'update'])->name('documents.update');
  Route::resource('documents', DocumentController::class)->except(['create', 'store', 'update']);
  Route::post('templateforms/{id}/changehierarchy', [TemplateFormController::class, 'change_hierarchy'])->name('change_hierarchy');
  Route::resource('templateforms', TemplateFormController::class)->except(['index', 'create', 'edit']);
  Route::get('generatesingle/{id}', [GenerateController::class, 'generatesingle'])->name('generate.single');
  Route::get('generatemulti', [GenerateController::class, 'generatemulti'])->name('generate.generatemulti');
});
