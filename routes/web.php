<?php
use App\Http\Controllers\MainController as M;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::post('/login', [M::class, 'login']);

Route::middleware('web')->group(function () {
    Route::get('/home', [M::class, 'home']);
    Route::get('/logout', [M::class, 'logout']);
    Route::get('/password', fn() => session('id') ? view('password') : redirect('/'));
    Route::post('/password', [M::class, 'password']);
    Route::post('/equipment', [M::class, 'register']);
    Route::post('/requests', [M::class, 'request']);
    Route::post('/decide/{id}/{status}', [M::class, 'decide'])->whereIn('status', ['approved', 'rejected']);
    Route::get('/{table}', [M::class, 'list'])->whereIn('table', ['equipment', 'requests']);
});
