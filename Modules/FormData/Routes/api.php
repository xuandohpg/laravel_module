<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\FormData\Http\Controllers\FormDataController;


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

 Route::middleware('auth:api')->get('/formdata', function (Request $request) {
     return $request->user();
 });


// Route::get('articles', 'ArticleController@index');
// Route::get('articles/{id}', 'ArticleController@show');
// Route::post('articles', 'ArticleController@store');
// Route::put('articles/{id}', 'ArticleController@update');
// Route::delete('articles/{id}', 'ArticleController@delete');

Route::post('formdata',[FormDataController::class,'add']);
Route::get('formdata',[FormDataController::class,'index']);

Route::put('formdata/{id}', [FormDataController::class,'update']);

Route::get('formdata/{id}', [FormDataController::class,'show']);










