<?php

use Illuminate\Http\Request;
use Modules\Offer\Http\Controllers\OfferController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/offer', function (Request $request) {
    return $request->user();
});

Route::post('offer', [OfferController::class, 'index']);

Route::get('offer/add', [OfferController::class, 'add']);


Route::get('formPub',function (){
    return $formPub=DB::table('form_pub')->get();
});

Route::post('offer/demo',[OfferController::class,'demo']);
