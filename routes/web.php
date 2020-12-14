<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\KelasController::class, 'index']);

Route::get('/kelas/browse', [App\Http\Controllers\KelasController::class, 'browse'])->name('kelas.browse');
Route::post('/kelas/browse/apply/{id}', [App\Http\Controllers\MendaftarController::class, 'apply'])->name('kelas.apply');


Route::get('/kelas/{id}/member', [App\Http\Controllers\KelasController::class, 'member'])->name('kelas.member');
Route::post('/kelas/{id}/member', [App\Http\Controllers\MendaftarController::class, 'response'])->name('kelas.response');

Route::get('/kelas/{id}/createpost', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');



Route::resource('post', App\Http\Controllers\PostController::class, ['except' => ['create']])->parameters([
    'post' => 'id']);;

Route::resource('kelas', App\Http\Controllers\KelasController::class)->parameters([
    'kelas' => 'id']);