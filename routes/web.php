<?php

use App\Model\HotelPGU;
use App\Model\JenisTiketReffDufan;
use App\Model\JenisTiketReffSW;
use App\Model\KodeScanDufan;
use App\Model\KodeScanODS;
use App\Model\KodeScanSW;
use App\Model\User;
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
    // $jenis = JenisTiketReffDufan::take(5)->get();
    // $user = User::all();
    // return response()->json($jenis);
    // return view('welcome', compact('user'));
    return redirect()->route('login');
});

Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('/post-login', 'Auth\AuthController@postLogin')->name('post-login');
Route::get('/register', 'Auth\AuthController@register')->name('register');
Route::post('/post-register', 'Auth\AuthController@postRegister')->name('post-register');
Route::get('/verify-account/{id}', 'Auth\AuthController@verifyAccount')->name('verify-account');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

Route::group(['prefix' => 'index', 'middleware' => 'auth'], function () {
    Route::get('/', 'Backend\User\DashboardController@index')->name('dashboard-user');
    Route::post('/reservation', 'Backend\User\DashboardController@reservation')->name('reservation');
    Route::get('/back-reservasion', 'Backend\User\DashboardController@backReservasion')->name('backReservasion');
    Route::get('/download-barcode', 'Backend\User\DashboardController@downloadBarcode')->name('downloadBarcode');
    Route::get('/profile', 'Backend\User\DashboardController@profile')->name('profile-user');
    Route::get('/riwayat', 'Backend\User\DashboardController@history')->name('history-transaction-user');
    Route::post('/changeProfile', 'Backend\User\DashboardController@changeProfile')->name('changeProfile');
    Route::get('/downloadTiketZip', 'Backend\User\DashboardController@downloadTiketZip')->name('download-tiket-zip');
    Route::get('/download-tiket-history/{id}', 'Backend\User\DashboardController@downloadHistory')->name('download-tiket-history');
});


Route::get('/download', 'Auth\AuthController@generateDownload')->name('download');

Route::get('/testing', function () {
    return response()->json(HotelPGU::take(2)->get());
})->name('testing');
