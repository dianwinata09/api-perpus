<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthC;
use App\Http\Controllers\BukuC;
use App\Http\Controllers\userC;
use App\Http\Controllers\PeminjamanC;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/buku', BukuC::class);
Route::apiResource('/pinjam', PeminjamanC::class);
Route::apiResource('/user', userC::class);

Route::post('/login', [AuthC::class, 'login']);

Route::get('/about', function () { 
    return 'dian | tri';
});