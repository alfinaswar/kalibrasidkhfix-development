<?php

use App\Http\Controllers\AlatUkurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\KajiUlangController;
use App\Http\Controllers\MasterAkomodasiController;
use App\Http\Controllers\MasterAlatController;
use App\Http\Controllers\MasterCustomerController;
use App\Http\Controllers\MasterFisikFungsiController;
use App\Http\Controllers\MasterKeselamatanListrikController;
use App\Http\Controllers\MasterMetodeController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProsesKalibrasiController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SerahTerimaAlatController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SuratPerintahKerjaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::GET('/info-kalibrasi/{NoSertifikat}', [PoController::class, 'infoKalibrasi'])->name('po.info');
Route::group(['middleware' => ['auth']], function () {
    // USER
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::prefix('master-inventori')->group(function () {
        Route::GET('/', [InventoriController::class, 'index'])->name('inv.index');
        Route::GET('/create', [InventoriController::class, 'create'])->name('inv.create');
        Route::GET('/create-kategori', [InventoriController::class, 'KategoriInventori'])->name('inv.create-kategori');
        Route::POST('/simpan', [InventoriController::class, 'store'])->name('inv.store');
        Route::POST('/simpan-kategori', [InventoriController::class, 'storeKategori'])->name('inv.store-kategori');
        Route::GET('/edit/{id}', [InventoriController::class, 'edit'])->name('inv.edit');
        Route::GET('/edit-kategori/{id}', [InventoriController::class, 'editKategori'])->name('inv.edit-kategori');
        Route::PUT('/update/{id}', [InventoriController::class, 'update'])->name('inv.update');
        Route::PUT('/update-kategori/{id}', [InventoriController::class, 'updateKategori'])->name('inv.update-kategori');
        Route::delete('hapus/{id}', [InventoriController::class, 'destroy'])->name('inv.destroy');
        Route::delete('hapus-kategori/{id}', [InventoriController::class, 'destroyKategori'])->name('inv.destroy-kategori');
    });
    Route::prefix('master-instrumen')->group(function () {
        Route::GET('/', [InstrumenController::class, 'index'])->name('instrumen.index');
        Route::GET('/create', [InstrumenController::class, 'create'])->name('instrumen.create');
        Route::POST('/simpan', [InstrumenController::class, 'store'])->name('instrumen.store');
        Route::GET('/edit/{id}', [InstrumenController::class, 'edit'])->name('instrumen.edit');
        Route::PUT('/update/{id}', [InstrumenController::class, 'update'])->name('instrumen.update');
        Route::PUT('/update-akre/{id}', [InstrumenController::class, 'updateAkre'])->name('instrumen.updateAkre');
        Route::delete('hapus/{id}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
        Route::get('/getHarga/{id}', [InstrumenController::class, 'getHarga'])->name('instrument.getHarga');
        Route::GET('/CekInstrumen', [InstrumenController::class, 'CekInstrumen'])->name('instrumen.CekInstrumen');
    });
    Route::prefix('master-parameter-fisik-fungsi')->group(function () {
        Route::GET('/', [MasterFisikFungsiController::class, 'index'])->name('fisikfungsi.index');
        Route::GET('/create', [MasterFisikFungsiController::class, 'create'])->name('fisikfungsi.create');
        Route::POST('/simpan', [MasterFisikFungsiController::class, 'store'])->name('fisikfungsi.store');
        Route::GET('/edit/{id}', [MasterFisikFungsiController::class, 'edit'])->name('fisikfungsi.edit');
        Route::PUT('/update/{id}', [MasterFisikFungsiController::class, 'update'])->name('fisikfungsi.update');
        Route::delete('hapus/{id}', [MasterFisikFungsiController::class, 'destroy'])->name('fisikfungsi.destroy');
    });
    Route::prefix('master-parameter-keselamatan-listrik')->group(function () {
        Route::GET('/', [MasterKeselamatanListrikController::class, 'index'])->name('keselamatanlistrik.index');
        Route::GET('/create', [MasterKeselamatanListrikController::class, 'create'])->name('keselamatanlistrik.create');
        Route::POST('/simpan', [MasterKeselamatanListrikController::class, 'store'])->name('keselamatanlistrik.store');
        Route::GET('/edit/{id}', [MasterKeselamatanListrikController::class, 'edit'])->name('keselamatanlistrik.edit');
        Route::PUT('/update/{id}', [MasterKeselamatanListrikController::class, 'update'])->name('keselamatanlistrik.update');
        Route::delete('hapus/{id}', [MasterKeselamatanListrikController::class, 'destroy'])->name('keselamatanlistrik.destroy');
    });
    Route::prefix('master-customer')->group(function () {
        Route::GET('/', [MasterCustomerController::class, 'index'])->name('customer.index');
        Route::GET('/create', [MasterCustomerController::class, 'create'])->name('customer.create');
        Route::POST('/simpan', [MasterCustomerController::class, 'store'])->name('customer.store');
        Route::GET('/edit/{id}', [MasterCustomerController::class, 'edit'])->name('customer.edit');
        Route::PUT('/update/{id}', [MasterCustomerController::class, 'update'])->name('customer.update');
        Route::delete('hapus/{id}', [MasterCustomerController::class, 'destroy'])->name('customer.destroy');
    });
    Route::prefix('master-akomodasi')->group(function () {
        Route::GET('/', [MasterAkomodasiController::class, 'index'])->name('akomodasi.index');
        Route::GET('/create', [MasterAkomodasiController::class, 'create'])->name('akomodasi.create');
        Route::POST('/simpan', [MasterAkomodasiController::class, 'store'])->name('akomodasi.store');
        Route::GET('/edit/{id}', [MasterAkomodasiController::class, 'edit'])->name('akomodasi.edit');
        Route::GET('/getTarif/{AkomodasiID}', [MasterAkomodasiController::class, 'getTarif'])->name('akomodasi.getTarif');
        Route::PUT('/update/{id}', [MasterAkomodasiController::class, 'update'])->name('akomodasi.update');
        Route::delete('hapus/{id}', [MasterAkomodasiController::class, 'destroy'])->name('akomodasi.destroy');
    });
    Route::prefix('master-satuan')->group(function () {
        Route::GET('/', [MasterSatuanController::class, 'index'])->name('satuan.index');
        Route::GET('/create', [MasterSatuanController::class, 'create'])->name('satuan.create');
        Route::POST('/simpan', [MasterSatuanController::class, 'store'])->name('satuan.store');
        Route::GET('/edit/{id}', [MasterSatuanController::class, 'edit'])->name('satuan.edit');
        Route::PUT('/update/{id}', [MasterSatuanController::class, 'update'])->name('satuan.update');
        Route::delete('hapus/{id}', [MasterSatuanController::class, 'destroy'])->name('satuan.destroy');
    });
    Route::prefix('serah-terima')->group(function () {
        Route::GET('/', [SerahTerimaAlatController::class, 'index'])->name('st.index');
        Route::GET('/create', [SerahTerimaAlatController::class, 'create'])->name('st.create');
        Route::POST('/simpan', [SerahTerimaAlatController::class, 'store'])->name('st.store');
        Route::GET('/edit/{id}', [SerahTerimaAlatController::class, 'edit'])->name('st.edit');
        Route::GET('/detail/{id}', [SerahTerimaAlatController::class, 'detail'])->name('st.detail');
        Route::POST('/update-data/{id}', [SerahTerimaAlatController::class, 'update'])->name('st.update');
        Route::delete('hapus/{id}', [SerahTerimaAlatController::class, 'destroy'])->name('st.destroy');
        Route::GET('/pdf/{id}', [SerahTerimaAlatController::class, 'GeneratePdf'])->name('st.pdf');
        Route::GET('/cetak-stiker/{id}', [SerahTerimaAlatController::class, 'CetakStiker'])->name('st.cetak-stiker');
        Route::put('/update-tanggal-diserahkan/{id}', [SerahTerimaAlatController::class, 'updateTanggalDiserahkan'])->name('st.UpdateDiserahkan');
    });
    Route::prefix('kaji-ulang')->group(function () {
        Route::GET('/', [KajiUlangController::class, 'index'])->name('ku.index');
        Route::GET('/create', [KajiUlangController::class, 'create'])->name('ku.create');
        Route::GET('/form-kaji-ulang/{id}', [KajiUlangController::class, 'formKaji'])->name('ku.form-kaji-ulang');
        Route::POST('/simpan', [KajiUlangController::class, 'store'])->name('ku.store');
        Route::GET('/edit/{id}', [KajiUlangController::class, 'edit'])->name('ku.edit');
        Route::GET('/detail/{id}', [KajiUlangController::class, 'show'])->name('ku.cetak');
        Route::GET('/cetak-kup/{id}', [KajiUlangController::class, 'cetakKup'])->name('ku.cetak-kup');
        Route::POST('/update-data/{id}', [KajiUlangController::class, 'update'])->name('ku.update');
        Route::delete('hapus/{id}', [KajiUlangController::class, 'destroy'])->name('ku.destroy');
    });
    Route::prefix('master-metode')->group(function () {
        Route::GET('/', [MasterMetodeController::class, 'index'])->name('metode.index');
        Route::delete('hapus/{id}', [MasterMetodeController::class, 'destroy'])->name('metode.destroy');
        Route::GET('/edit/{id}', [MasterMetodeController::class, 'edit'])->name('metode.edit');
        Route::POST('/simpan', [MasterMetodeController::class, 'store'])->name('metode.store');
        Route::PUT('/update/{id}', [MasterMetodeController::class, 'update'])->name('metode.update');
    });
    Route::prefix('quotation')->group(function () {
        Route::GET('/', [QuotationController::class, 'index'])->name('quotation.index');
        Route::GET('/buat/{id}', [QuotationController::class, 'create'])->name('quotation.form-quotation');
        Route::POST('/simpan', [QuotationController::class, 'store'])->name('quotation.store');
        Route::GET('/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
        Route::POST('/update/{id}', [QuotationController::class, 'update'])->name('quotation.update');
        Route::delete('hapus/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
        Route::GET('/cetak-pdf/{id}', [QuotationController::class, 'GeneratePdf'])->name('quotation.pdf');
        Route::POST('/approval', [QuotationController::class, 'Approval'])->name('quotation.approval');
        // Route::GET('/cari-data/{id}', [QuotationController::class, 'GeneratePdf'])->name('quotation.pdf');
    });
    Route::prefix('po')->group(function () {
        Route::GET('/', [PoController::class, 'index'])->name('po.index');
        Route::GET('/buat/{id}', [PoController::class, 'create'])->name('po.form-po');
        Route::GET('/buat-tanpa-qo', [PoController::class, 'createTanpaQo'])->name('po.po-tanpa-qo');
        Route::POST('/simpan', [PoController::class, 'store'])->name('po.store');
        Route::GET('/edit/{id}', [PoController::class, 'edit'])->name('po.edit');
        Route::POST('/update/{id}', [PoController::class, 'update'])->name('po.update');
        Route::delete('hapus/{id}', [PoController::class, 'destroy'])->name('po.destroy');
        Route::GET('/cetak-pdf/{id}', [PoController::class, 'GeneratePdf'])->name('po.pdf');
        Route::GET('/cetak-stiker/{id}', [PoController::class, 'CetakStiker'])->name('po.stiker');
        Route::POST('/approval', [PoController::class, 'Approval'])->name('po.approval');
    });
    Route::prefix('surat-tugas')->group(function () {
        Route::GET('/', [SuratPerintahKerjaController::class, 'index'])->name('spk.index');
        Route::GET('/surat-tugas/po/{id}', [SuratPerintahKerjaController::class, 'create'])->name('spk.form-spk');
        Route::GET('/surat-tugas/', [SuratPerintahKerjaController::class, 'create'])->name('spk.form');
        Route::POST('/simpan', [SuratPerintahKerjaController::class, 'store'])->name('spk.store');
        Route::GET('/edit/{id}', [SuratPerintahKerjaController::class, 'edit'])->name('spk.edit');
        Route::PUT('/update/{id}', [SuratPerintahKerjaController::class, 'update'])->name('spk.update');
        Route::delete('hapus/{id}', [SuratPerintahKerjaController::class, 'destroy'])->name('spk.destroy');
        Route::GET('/cetak-pdf/{id}', [SuratPerintahKerjaController::class, 'GeneratePdf'])->name('ku.pdf');
    });
    Route::prefix('job-order')->group(function () {
        Route::GET('/', [SertifikatController::class, 'index'])->name('job.index');
        Route::GET('/hasil-kalibrasi/{id}', [SertifikatController::class, 'HasilKalibrasi'])->name('job.HasilKalibrasi');
        Route::GET('/kalibrasi/{id}', [SertifikatController::class, 'create'])->name('job.kalibrasi');
        Route::GET('/hasil-pdf/{id}', [SertifikatController::class, 'HasilPdf'])->name('job.hasilpdf');
        Route::GET('/download-excel/{id}', [SertifikatController::class, 'DownloadExcel'])->name('job.downloadExcel');
        // Route::GET('/surat-tugas/', [SuratPerintahKerjaController::class, 'create'])->name('spk.form');
        Route::POST('/simpan', [SertifikatController::class, 'store'])->name('job.store');
        Route::POST('/simpan-tanpa-lk', [SertifikatController::class, 'StoreTanpaLK'])->name('job.StoreTanpaLK');
        Route::POST('/simpan-hasil', [SertifikatController::class, 'storeHasil'])->name('job.storeHasil');
        Route::POST('/approval', [SertifikatController::class, 'Approval'])->name('job.approval');
        Route::get('/get-verifikasi-teknis/{id}', [SertifikatController::class, 'getVerifTeknis'])->name('job.Verif');
        Route::POST('/approval', [SertifikatController::class, 'Approval'])->name('job.approval');
        Route::POST('/simpan-verif-teknis', [SertifikatController::class, 'StoreVerif'])->name('job.StoreVerif');
        Route::POST('/simpan-valid-mutu', [SertifikatController::class, 'StoreMutu'])->name('job.StoreMutu');
    });
});
