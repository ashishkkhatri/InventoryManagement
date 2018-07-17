<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('inventory')->group(function(){
        Route::get('/','Inventory\InventoryController@getInventory')->middleware('permission:view_inventory');
        Route::post('/edit','Inventory\InventoryController@editInventory')->middleware('permission:edit_inventory');
        Route::post('/add','Inventory\InventoryController@addInventory')->middleware('permission:add_inventory');
        Route::post('/delete','Inventory\InventoryController@deleteInventory')->middleware('permission:delete_inventory');
        Route::post('/approve','Inventory\InventoryController@approveInventory')->middleware('permission:approve_inventory');
    });
    Route::post('approve-user','UserController@approveUser')->middleware('role:store_manager');
    Route::get('store-assistant-list','UserController@getAssistantList')->middleware('role:store_manager');
});

Route::get('welcome',function(){
    return response()->json(['message'=>'Hello World']);
});

Route::prefix('auth')->group(function(){
    Route::post('login','Auth\LoginController@login');
    Route::post('register','Auth\RegisterController@register');
});