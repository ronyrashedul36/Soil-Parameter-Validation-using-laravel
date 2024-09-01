<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpazilaNirdesikhaController;
use App\Http\Controllers\PhpSpreadsheetController;

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

// Route::get('/', function () {
//     return view('demo');
// });

Route::post('/upload', [PhpSpreadsheetController::class, 'upload'])->name('PhpSpreadsheetController.upload');

Route::post('/processFile',[PhpSpreadsheetController::class,'processFile'])->name('PhpSpreadsheetController.processFile');

Route::post('/checkFileStatus', [PhpSpreadsheetController::class, 'checkFileStatus'])->name('PhpSpreadsheetController.checkFileStatus');

Route::get('/downloadFile', [PhpSpreadsheetController::class, 'downloadFile'])->name('PhpSpreadsheetController.downloadFile');

Route::post('/submit-soil-data', [PhpSpreadsheetController::class, 'storeSoilData'])->name('PhpSpreadsheetController.storeSoilData');

Route::get('/soilchemicaldata', function() {
    return view('soilchemicaldata');
});


Route::get('/demo', function () {
    return view('demo');
});

Route::get('/inputform', function(){
    return view('inputform');
});

Route::get('/soilvalidation', function(){
    return view('soilvalidation');
});





Route::post('/submit', [UpazilaNirdesikhaController::class, 'store'])->name('submit.form');

Route::get('/demo', [UpazilaNirdesikhaController::class, 'show'])->name('upazila-nirdesika.show');

Route::get('/soilchemicaldata', [UpazilaNirdesikhaController::class, 'show1'])->name('soilchemicaldata.show1');

Route::get('/download/{FilePath}', [UpazilaNirdesikhaController::class, 'download'])->name('download.file');

Route::delete('/delete/{id}', [UpazilaNirdesikhaController::class, 'delete'])->name('delete.file');

Route::delete('/deletesoilchemicaldata/{id}', [UpazilaNirdesikhaController::class, 'deletesoilchemicaldata'])->name('deletesoilchemicaldata');

Route::get('edit/{id}', [UpazilaNirdesikhaController::class, 'edit']);

Route::get('editsoilchemicaldata/{id}', [UpazilaNirdesikhaController::class, 'editsoilchemicaldata']);

Route::put('update_data/{id}', [UpazilaNirdesikhaController::class, 'update_data']);

Route::put('update_soilchemicaldata/{id}', [UpazilaNirdesikhaController::class, 'update_soilchemicaldata']);



