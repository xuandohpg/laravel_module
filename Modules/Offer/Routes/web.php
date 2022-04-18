<?php
use Modules\Offer\Http\Controllers\OfferController;
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

Route::prefix('offer')->group(function() {
    Route::get('/', 'OfferController@index');
});


Route::get('offer',[OfferController::class,'index']);

// Route::get('offer/add',[OfferController::class,'add']);
