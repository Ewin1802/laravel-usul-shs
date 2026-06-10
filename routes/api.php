<?php

use App\Http\Controllers\Api1\AuthController;
use App\Http\Controllers\Api\CreateUsulanController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\OpsiDasarController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsulanSkpdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::apiResource('users', UserController::class);
    Route::put('/users/update', [UserController::class, 'updateuser']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'adminUpdate']);
    Route::put('/users/{id}/reset-password', [UserController::class, 'resetPassword']);

    /*
    |--------------------------------------------------------------------------
    | USULAN DATA
    |--------------------------------------------------------------------------
    */

    Route::prefix('usulan')->controller(UsulanSkpdController::class)->group(function () {

        // ambil data usulan
        Route::get('/shs', 'data_shs');
        Route::get('/sbu', 'data_sbu');
        Route::get('/asb', 'data_asb');
        Route::get('/hspk', 'data_hspk');

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI / APPROVE / REJECT
        |--------------------------------------------------------------------------
        | memakai parameter {type}
        | type = shs | sbu | asb | hspk
        */

        Route::put('/{type}/{id}/verifikasi', 'verified');
        Route::put('/{type}/{id}/disetujui', 'approve');
        Route::put('/{type}/{id}/ditolak', 'reject');
    });


    /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/statistik/usulan/{type}/{tahun}',
        [UsulanSkpdController::class, 'statistik']
    );


    /*
    |--------------------------------------------------------------------------
    | OPSI DASAR (MASTER DATA)
    |--------------------------------------------------------------------------
    */

    Route::prefix('opsi')->controller(OpsiDasarController::class)->group(function () {

        Route::get('/kelompok', 'kelompok');
        Route::get('/satuan', 'satuan');
        Route::get('/skpd', 'skpd');
        Route::get('/belanja', 'belanja');
        Route::get('/dokumen', 'dokumen');
    });


    /*
    |--------------------------------------------------------------------------
    | CREATE USULAN
    |--------------------------------------------------------------------------
    */

    Route::prefix('create-usulan')->controller(CreateUsulanController::class)->group(function () {

        Route::post('/shs', 'createshs');
        Route::post('/sbu', 'createsbu');
        Route::post('/asb', 'createasb');
        Route::post('/hspk', 'createhspk');
    });


    /*
    |--------------------------------------------------------------------------
    | DOKUMEN
    |--------------------------------------------------------------------------
    */

    Route::prefix('dokumen')->controller(DokumenController::class)->group(function () {
        Route::post('/upload', 'docstore');
        Route::get('/surat', 'list_surat');
    });
});
