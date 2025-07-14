<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\BelanjaApiController;
use App\Http\Controllers\UsulSHSController;
use App\Http\Controllers\UsulSBUController;
use App\Http\Controllers\UsulASBController;
use App\Http\Controllers\UsulHSPKController;
use App\Http\Controllers\DocumentController;
use App\Exports\SHSExport;
use App\Exports\SBUExport;
use App\Exports\ASBExport;
use App\Exports\HSPKExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Proses_shs;
use App\Models\Proses_sbu;
use App\Models\Proses_asb;
use App\Models\Proses_hspk;
use App\Http\Controllers\CetakPdfController;

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

// Semua peran bisa mengakses halaman login
// Route::get('/', function () {
//     return view('pages.auth.login');
// });

Route::get('/', function () {
    return view('pages.landing');
});
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('home', function () {
        return redirect()->route('dashboard');
        })->name('home');
    Route::get('/dashboard', [UserController::class, 'showData'])->name('dashboard');

    // SKPD bisa mengakses dashboard, documents, shs, dan sbu
    Route::middleware(['auth', 'role:SKPD'])->group(function () {
        // Route::resource('documents', DocumentController::class);
        Route::get('/docs_user', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/docs_create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/docs_store', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/contoh_surats/download', [DocumentController::class, 'download'])->name('contoh_surats.download');

        Route::get('shs/index', [UsulSHSController::class, 'index'])->name('shs.index');
        Route::get('shs/create', [UsulSHSController::class, 'create'])->name('shs.create');
        Route::post('shs/store', [UsulSHSController::class, 'store'])->name('shs.store');
        Route::get('shs/{id}/useredit', [UsulSHSController::class, 'edituser'])->name('shs_user.edit');
        Route::put('/shs/{id}', [UsulSHSController::class, 'updateuser'])->name('shs_user.ubah');

        Route::get('sbu/index', [UsulSBUController::class, 'index'])->name('sbu.index');
        Route::get('sbu/create', [UsulSBUController::class, 'create'])->name('sbu.create');
        Route::post('sbu/store', [UsulSBUController::class, 'store'])->name('sbu.store');
        Route::get('sbu/{id}/useredit', [UsulSBUController::class, 'edituser'])->name('sbu_user.edit');
        Route::put('/sbu/{id}', [UsulSBUController::class, 'updateuser'])->name('sbu_user.ubah');

        Route::get('asb/index', [UsulASBController::class, 'index'])->name('asb.index');
        Route::get('asb/create', [UsulASBController::class, 'create'])->name('asb.create');
        Route::post('asb/store', [UsulASBController::class, 'store'])->name('asb.store');
        Route::get('asb/{id}/useredit', [UsulASBController::class, 'edituser'])->name('asb_user.edit');
        Route::put('/asb/{id}', [UsulASBController::class, 'updateuser'])->name('asb_user.ubah');

        Route::get('hspk/index', [UsulHSPKController::class, 'index'])->name('hspk.index');
        Route::get('hspk/create', [UsulHSPKController::class, 'create'])->name('hspk.create');
        Route::post('hspk/store', [UsulHSPKController::class, 'store'])->name('hspk.store');
        Route::get('hspk/{id}/useredit', [UsulHSPKController::class, 'edituser'])->name('hspk_user.edit');
        Route::put('/hspk/{id}', [UsulHSPKController::class, 'updateuser'])->name('hspk_user.ubah');

    });

    // ADMIN bisa mengakses semuanya
    Route::middleware(['auth', 'role:ADMIN'])->group(function () {

        Route::get('admin/docs_admin', [DocumentController::class, 'admin_index'])->name('docs_admin');
        Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('admin/contohsurat_create', [DocumentController::class, 'createContohSurat'])->name('docs_admin.create');
        Route::post('admin/contohsurat_store', [DocumentController::class, 'upload'])->name('docs_admin.store');

        Route::get('shs/admin_shs', [UsulSHSController::class, 'admin_shs'])->name('shs.admin_shs');
        Route::post('shs/{id}/verified', [UsulSHSController::class, 'verified'])->name('shs.verified');
        Route::post('shs/{id}/tolak', [UsulSHSController::class, 'tolak'])->name('shs.tolak');
        Route::delete('shs/{id}/hapus', [UsulSHSController::class, 'destroy'])->name('shs.hapus');
        Route::get('shs/export_shs', [UsulSHSController::class, 'admin_export_shs'])->name('shs.export_shs');
        Route::get('shs/{id}/edit', [UsulSHSController::class, 'edit'])->name('shs_admin.edit');
        Route::put('/shs/{usulan}/update', [UsulSHSController::class, 'update'])->name('shs.ubah');

        Route::get('sbu/admin_sbu', [UsulSBUController::class, 'admin_sbu'])->name('sbu.admin_sbu');
        Route::post('sbu/{id}/verified', [UsulSBUController::class, 'verified'])->name('sbu.verified');
        Route::post('sbu/{id}/tolak', [UsulSBUController::class, 'tolak'])->name('sbu.tolak');
        Route::delete('sbu/{id}/hapus', [UsulSBUController::class, 'destroy'])->name('sbu.hapus');
        Route::get('sbu/export_sbu', [UsulSBUController::class, 'admin_export_sbu'])->name('sbu.export_sbu');
        Route::get('sbu/{id}/edit', [UsulSBUController::class, 'edit'])->name('sbu_admin.edit');
        Route::put('/sbu/{usulan}/update', [UsulSBUController::class, 'update'])->name('sbu.ubah');

        Route::get('asb/admin_asb', [UsulASBController::class, 'admin_asb'])->name('asb.admin_asb');
        Route::post('asb/{id}/verified', [UsulASBController::class, 'verified'])->name('asb.verified');
        Route::post('asb/{id}/tolak', [UsulASBController::class, 'tolak'])->name('asb.tolak');
        Route::delete('asb/{id}/hapus', [UsulASBController::class, 'destroy'])->name('asb.hapus');
        Route::get('asb/export_asb', [UsulASBController::class, 'admin_export_asb'])->name('asb.export_asb');
        Route::get('asb/{id}/edit', [UsulASBController::class, 'edit'])->name('asb_admin.edit');
        Route::put('/asb/{usulan}/update', [UsulASBController::class, 'update'])->name('asb.ubah');

        Route::get('hspk/admin_hspk', [UsulHSPKController::class, 'admin_hspk'])->name('hspk.admin_hspk');
        Route::post('hspk/{id}/verified', [UsulHSPKController::class, 'verified'])->name('hspk.verified');
        Route::post('hspk/{id}/tolak', [UsulHSPKController::class, 'tolak'])->name('hspk.tolak');
        Route::delete('hspk/{id}/hapus', [UsulHSPKController::class, 'destroy'])->name('hspk.hapus');
        Route::get('hspk/export_hspk', [UsulHSPKController::class, 'admin_export_hspk'])->name('hspk.export_hspk');
        Route::get('hspk/{id}/edit', [UsulHSPKController::class, 'edit'])->name('hspk_admin.edit');
        Route::put('/hspk/{usulan}/update', [UsulHSPKController::class, 'update'])->name('hspk.ubah');

        Route::get('user/index', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('user/{id}/hapus', [UsulASBController::class, 'destroy'])->name('user.destroy');
        Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');

        Route::get('/skpd', [SkpdController::class, 'index'])->name('skpd.index');
        Route::post('/skpd/import', [SkpdController::class, 'import'])->name('skpd.import');
        Route::get('/skpd/edit/{id}', [SkpdController::class, 'edit'])->name('skpd.edit');
        Route::put('/skpd/update/{id}', [SkpdController::class, 'update'])->name('skpd.update');

        Route::get('/satuans', [SatuanController::class, 'index'])->name('satuan.index');
        Route::post('/satuans/import', [SatuanController::class, 'import'])->name('satuans.import');
        Route::get('/satuan/edit/{id}', [SatuanController::class, 'edit'])->name('satuan.edit');
        Route::put('/satuan/update/{id}', [SatuanController::class, 'update'])->name('satuan.update');

        Route::get('/kelompok', [KelompokController::class, 'index'])->name('kelompok.index');
        Route::post('/kelompok/import', [KelompokController::class, 'import'])->name('kelompok.import');
        Route::get('/kelompok/edit/{id}', [KelompokController::class, 'edit'])->name('kelompok.edit');
        Route::put('/kelompok/update/{id}', [KelompokController::class, 'update'])->name('kelompok.update');

        Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja.index');
        Route::post('/belanja/import', [BelanjaController::class, 'import'])->name('belanja.import');
        Route::get('/belanjaApi', [BelanjaApiController::class, 'index'])->name('belanjaApi.index');
        Route::post('/belanjaApi/import', [BelanjaApiController::class, 'import'])->name('belanjaApi.import');
        Route::get('/belanjaApi/edit/{id}', [BelanjaApiController::class, 'edit'])->name('belanjaApi.edit');
        Route::put('/belanjaApi/update/{id}', [BelanjaApiController::class, 'update'])->name('belanjaApi.update');
        Route::delete('belanjaApi/{id}/hapus', [BelanjaApiController::class, 'destroy'])->name('belanjaApi.hapus');

        Route::get('/shs/generate-pdf', [CetakPdfController::class, 'shsgeneratePDF'])->name('shsgenerate-pdf');
        Route::get('/sbu/generate-pdf', [CetakPdfController::class, 'sbugeneratePDF'])->name('sbugenerate-pdf');
        Route::get('/asb/generate-pdf', [CetakPdfController::class, 'asbgeneratePDF'])->name('asbgenerate-pdf');
        Route::get('/hspk/generate-pdf', [CetakPdfController::class, 'hspkgeneratePDF'])->name('hspkgenerate-pdf');

        Route::get('export-shs', function () {
            $excel = Excel::raw(new SHSExport, \Maatwebsite\Excel\Excel::XLSX);
            Proses_shs::truncate();
            return response()->streamDownload(function() use ($excel) {
                echo $excel;
            }, 'shs.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'no-store, no-cache',
            ]);
        })->name('shs.export');

        Route::get('export-sbu', function () {
                $excel = Excel::raw(new SBUExport, \Maatwebsite\Excel\Excel::XLSX);
                Proses_sbu::truncate();
                return response()->streamDownload(function() use ($excel) {
                    echo $excel;
                }, 'sbu.xlsx', [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Cache-Control' => 'no-store, no-cache',
                ]);
            })->name('sbu.export');
        });

        Route::get('export-asb', function () {
                $excel = Excel::raw(new ASBExport, \Maatwebsite\Excel\Excel::XLSX);
                Proses_asb::truncate();
                return response()->streamDownload(function() use ($excel) {
                    echo $excel;
                }, 'asb.xlsx', [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Cache-Control' => 'no-store, no-cache',
                ]);
            })->name('asb.export');

        Route::get('export-hspk', function () {
                $excel = Excel::raw(new HSPKExport, \Maatwebsite\Excel\Excel::XLSX);
                Proses_hspk::truncate();
                return response()->streamDownload(function() use ($excel) {
                    echo $excel;
                }, 'hspk.xlsx', [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Cache-Control' => 'no-store, no-cache',
                ]);
            })->name('hspk.export');
        });








