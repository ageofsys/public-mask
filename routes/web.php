<?php

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

Route::get('/', "SearchController@index")->name("welcome");

Route::resource("stores", "StoreController");

Route::resource("sales", "SaleController");

Route::get("search", "SearchController@index")->name("search.index");
Route::get("search/stores", "SearchController@searchOnMap");

Route::get("sync/stores", "SyncController@syncStores");
Route::get("sync/sales", "SyncController@syncSales");
