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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Resgister
Route::post('/register', [AuthController::class, 'register']);

//login
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Users
Route::apiResource('users', \App\Http\Controllers\Api\UserController::class)->middleware('auth:sanctum');
Route::put('/updateuser', [UserController::class, 'updateuser'])->middleware('auth:sanctum');

Route::get('shs_usul', [UsulanSkpdController::class, 'data_shs'])->middleware('auth:sanctum');
Route::get('sbu_usul', [UsulanSkpdController::class, 'data_sbu'])->middleware('auth:sanctum');
Route::get('asb_usul', [UsulanSkpdController::class, 'data_asb'])->middleware('auth:sanctum');
Route::get('hspk_usul', [UsulanSkpdController::class, 'data_hspk'])->middleware('auth:sanctum');
Route::put('/usulanshs/{id}/verifikasi', [UsulanSkpdController::class, 'verifiedShs'])->middleware('auth:sanctum');
Route::put('/usulanshs/{id}/disetujui', [UsulanSkpdController::class, 'approveShs'])->middleware('auth:sanctum');
Route::put('/usulanshs/{id}/ditolak', [UsulanSkpdController::class, 'tolakShs'])->middleware('auth:sanctum');
Route::put('/usulansbu/{id}/verifikasi', [UsulanSkpdController::class, 'verifiedSbu'])->middleware('auth:sanctum');
Route::put('/usulansbu/{id}/disetujui', [UsulanSkpdController::class, 'approveSbu'])->middleware('auth:sanctum');
Route::put('/usulansbu/{id}/ditolak', [UsulanSkpdController::class, 'tolakSbu'])->middleware('auth:sanctum');
Route::put('/usulanasb/{id}/verifikasi', [UsulanSkpdController::class, 'verifiedAsb'])->middleware('auth:sanctum');
Route::put('/usulanasb/{id}/disetujui', [UsulanSkpdController::class, 'approveAsb'])->middleware('auth:sanctum');
Route::put('/usulanasb/{id}/ditolak', [UsulanSkpdController::class, 'tolakAsb'])->middleware('auth:sanctum');
Route::put('/usulanhspk/{id}/verifikasi', [UsulanSkpdController::class, 'verifiedHspk'])->middleware('auth:sanctum');
Route::put('/usulanhspk/{id}/disetujui', [UsulanSkpdController::class, 'approveHspk'])->middleware('auth:sanctum');
Route::put('/usulanhspk/{id}/ditolak', [UsulanSkpdController::class, 'tolakHspk'])->middleware('auth:sanctum');

Route::get('list-kelompok', [OpsiDasarController::class, 'kelompok'])->middleware('auth:sanctum');
Route::get('list-satuan', [OpsiDasarController::class, 'satuan'])->middleware('auth:sanctum');
Route::get('list-skpd', [OpsiDasarController::class, 'skpd'])->middleware('auth:sanctum');

//hanya mengambil belanja Api saja, jumlah rek disini terbatas, tidak seperti pengajuan lewat web
Route::get('list-belanjaApi', [OpsiDasarController::class, 'belanja'])->middleware('auth:sanctum');

Route::get('list-dokumen', [OpsiDasarController::class, 'dokumen'])->middleware('auth:sanctum');

Route::post('create-shs', [CreateUsulanController::class, 'createshs'])->middleware('auth:sanctum');
Route::post('create-sbu', [CreateUsulanController::class, 'createsbu'])->middleware('auth:sanctum');
Route::post('create-asb', [CreateUsulanController::class, 'createasb'])->middleware('auth:sanctum');
Route::post('create-hspk', [CreateUsulanController::class, 'createhspk'])->middleware('auth:sanctum');

Route::post('create-dok', [DokumenController::class, 'docstore'])->middleware('auth:sanctum');
Route::get('list-surat', [DokumenController::class, 'list_surat'])->middleware('auth:sanctum');

