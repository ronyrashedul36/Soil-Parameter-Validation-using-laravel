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

Route::post('/soilsinglerowdataentry', [PhpSpreadsheetController::class, 'storeSoilData'])->name('PhpSpreadsheetController.storeSoilData');

Route::post('/submit-soil-data', [PhpSpreadsheetController::class, 'retrieveData'])->name('PhpSpreadsheetController.retrieveData');


Route::post('/upazilanirdesikareport', [PhpSpreadsheetController::class, 'retrieveNirdesikaData'])->name('PhpSpreadsheetController.retrieveNirdesikaData');

Route::post('/download', [PhpSpreadsheetController::class, 'download'])->name('PhpSpreadsheetController.download');

Route::post('/downloadNirdesikaData', [PhpSpreadsheetController::class, 'downloadNirdesikaData'])->name('PhpSpreadsheetController.downloadNirdesikaData');

Route::post('/signin', [PhpSpreadsheetController::class, 'signin'])->name('PhpSpreadsheetController.signin');

Route::post('/login', [PhpSpreadsheetController::class, 'login'])->name('PhpSpreadsheetController.login');

Route::post('/logout', [PhpSpreadsheetController::class, 'logout'])->name('PhpSpreadsheetController.logout');

Route::get('/getMessages', [PhpSpreadsheetController::class, 'getMessagesData'])->name('PhpSpreadsheetController.getMessages');

Route::get('/getData', [PhpSpreadsheetController::class, 'getData'])->name('PhpSpreadsheetController.getData'); 

Route::get('/updateMessageAndsoilData/{division}/{district}/{upazila}/{year}', [PhpSpreadsheetController::class, 'updateMessageAndsoilData'])->name('PhpSpreadsheetController.updateMessageAndsoilData');

Route::delete('/deleteMessage/{id}', [PhpSpreadsheetController::class, 'deleteMessage'])->name('PhpSpreadsheetController.deleteMessage');

// super admin data  download
Route::get('/download/{division}/{district}/{upazila}/{year}', [PhpSpreadsheetController::class, 'downloadExcel'])->name('PhpSpreadsheetController.downloadExcel');

Route::post('/rejectMessage/{division}/{district}/{upazila}/{year}', [PhpSpreadsheetController::class, 'rejectMessage'])->name('PhpSpreadsheetController.rejectMessage');

Route::post('/approveRequest', [PhpSpreadsheetController::class, 'approveRequest'])->name('PhpSpreadsheetController.approveRequest');


Route::get('/getUpazilaNirdesikhaCount', [PhpSpreadsheetController::class, 'getUpazilaNirdesikhaCount'])->name('PhpSpreadsheetController.getUpazilaNirdesikhaCount');
Route::get('/getSoilChemicalDataCount', [PhpSpreadsheetController::class, 'getSoilChemicalDataCount'])->name('PhpSpreadsheetController.getSoilChemicalDataCount');



Route::get('/soilchemicaldata', function() {
    return view('soilchemicaldata');
});

Route::get('/upazilanirdesikareport', function() {
    return view('upazilanirdesikareport');
});

Route::get('/notifications', function() {
    return view('notifications');
});

Route::get('/home', function() {
    return view('home');
});

Route::get('/reportofsoilchemicaldata', function() {
return view('/reportofsoilchemicaldata');
});

Route::get('/login', function() {
    return view('/login');
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

Route::get('/soilsinglerowdataentry', function(){
    return view('soilsinglerowdataentry');
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



