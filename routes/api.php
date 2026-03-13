<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsulanSkpdController;
use App\Http\Controllers\Api\CreateUsulanController;
use App\Http\Controllers\Api\OpsiDasarController;
use App\Http\Controllers\Api\DokumenController;

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


    /*
    |--------------------------------------------------------------------------
    | USULAN DATA
    |--------------------------------------------------------------------------
    */

    Route::prefix('usulan')->controller(UsulanSkpdController::class)->group(function () {

        Route::get('/shs', 'data_shs');
        Route::get('/sbu', 'data_sbu');
        Route::get('/asb', 'data_asb');
        Route::get('/hspk', 'data_hspk');

        Route::put('/shs/{id}/verifikasi', 'verifiedShs');
        Route::put('/shs/{id}/disetujui', 'approveShs');
        Route::put('/shs/{id}/ditolak', 'tolakShs');

        Route::put('/sbu/{id}/verifikasi', 'verifiedSbu');
        Route::put('/sbu/{id}/disetujui', 'approveSbu');
        Route::put('/sbu/{id}/ditolak', 'tolakSbu');

        Route::put('/asb/{id}/verifikasi', 'verifiedAsb');
        Route::put('/asb/{id}/disetujui', 'approveAsb');
        Route::put('/asb/{id}/ditolak', 'tolakAsb');

        Route::put('/hspk/{id}/verifikasi', 'verifiedHspk');
        Route::put('/hspk/{id}/disetujui', 'approveHspk');
        Route::put('/hspk/{id}/ditolak', 'tolakHspk');
    });

    /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

    Route::get('/statistik/usulan/{type}/{tahun}', [UsulanSkpdController::class, 'statistik']);


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
