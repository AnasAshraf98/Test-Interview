<?php

use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->get('/user',function(Request $request){
    return $request->user();
});

Route::controller(ItemController::class)->group(function(){
    Route::get('/items','index');
    Route::get('/completed','getItemsCompleted');
    Route::get('/remained','getItemsremained');
    Route::get('/checkDate','checkDate');

    Route::prefix('/item')->group(function(){
        Route::post('/store','store');
        Route::put('/{id}','update');
        Route::delete('/{id}','destroy');
        Route::put('/edit/{id}','updateTask');
    });
});
