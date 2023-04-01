<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login and Register
Route::post('register', 'AuthController@daftar');
Route::post('login', 'AuthController@login');


Route::group(['middleware' => ['jwt.verify']], function() {
        
    // Checklist
    Route::get('/checklist', 'ChecklistController@index');
    Route::post('/checklist', 'ChecklistController@store');
    Route::delete('/checklist/{id}', 'ChecklistController@destroy');



    // Checklist Item
    Route::get('/checklist/{checklistId}/item', 'ChecklistItemController@index');
    Route::post('/checklist/{checklistId}/item', 'ChecklistItemController@store');
    Route::get('/checklist/{checklistId}/item/{checklistItemId}', 'ChecklistItemController@show');
    Route::put('/checklist/{checklistId}/item/{checklistItemId}', 'ChecklistItemController@update');
    Route::delete('/checklist/{checklistId}/item/{checklistItemId}', 'ChecklistItemController@destroy');
    Route::put('/checklist/{checklistId}/item/rename/{checklistItemId}', 'ChecklistItemController@rename');
});
