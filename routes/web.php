<?php

use App\Http\Controllers\CheckinController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PlanController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

//basic authenticated routes
Route::group(['middleware' => ['account.config', 'auth']], function () {

    //shared and anon routes
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Route::resource('organization', OrganizationController::class);
    // Route::resource('location', LocationController::class);

    // Route::get('organization', [OrganizationController::class);
    /*
    Route::get('organization', [OrganizationController::class, 'index'])->name('organization.index');
    Route::get('organization/{organization}', [OrganizationController::class, 'show'])->name('organization.show');
    Route::get('organization/{organization}/edit', [OrganizationController::class, 'edit'])->name('organization.edit');
    Route::post('organization/{organization}', [OrganizationController::class, 'update'])->name('organization.update');
    Route::delete('organization/{organization}', [OrganizationController::class, 'delete'])->name('organization.delete');
    */

    Route::resource('organization', OrganizationController::class);
    Route::resource('location', LocationController::class);
    Route::resource('plan', PlanController::class);

    Route::get('organization/create', [OrganizationController::class, 'create'])->name('organization.create');
    /*
    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization.index');
    Route::get('/organization/{organization}', [OrganizationController::class, 'show'])->name('organization.show');
    Route::get('/locatin/{location}', [LocationController::class, 'show'])->name('location.show');
    */
    Route::post('/organization/search', [OrganizationController::class, 'search'])->name('organization.search');
    

    // Route::get('location/create', [LocationController::class, 'create'])->name('location.create');
    // Route::get('location/{location}', [LocationController::class, 'show'])->name('location.show');
    // Route::post('location', [LocationController::class, 'store'])->name('location.store');
    // Route::get('location/{location}/edit', [LocationController::class, 'edit'])->name('location.edit');
    // Route::post('location/{location}', [LocationController::class, 'update'])->name('location.update');
    // Route::delete('location/{location}', [LocationController::class, 'delete'])->name('location.delete');

    Route::get('/location/{location}/pdf', [LocationController::class, 'pdf'])->name('location.pdf');

    /*
    //accounts
    Route::resource('/account', 'AccountController')->except(['index', 'create', 'store']);
    Route::get('/confirm', 'AccountController@confirm')->name('account.confirm');
    Route::post('/confirmed', 'AccountController@confirmed')->name('account.confirmed');
    Route::post('/sendcode', 'AccountController@sendcode')->name('account.sendcode');

    Route::get('/me', 'AccountController@me')->name('account.me');
    */
});

Route::group(['middleware' => ['account.checkin']], function () {
    //checkin
    Route::get('/checkin', [CheckinController::class, 'signin'])->name('checkin.signin');
    Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin.store');

    Route::get('/checkin/{organization}/{code}', [CheckinController::class, 'qrcode'])->name('checkin.qrcode');
});

Auth::routes();
