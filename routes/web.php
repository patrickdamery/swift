<?php

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
    return view('install.pages.install');
});

Route::prefix('alonica')->group(function() {
  Route::post('user', 'AlonicaController@user');
});

Route::prefix('swift')->group(function() {
  Route::prefix('install')->group(function() {
    Route::post('load_modules', 'InstallController@load_modules');
    Route::post('launch_swift', 'InstallController@launch_swift');
    Route::get('download_branches', 'InstallController@download_branches');
    Route::get('download_staff', 'InstallController@download_staff');
    Route::get('download_clients', 'InstallController@download_clients');
    Route::get('download_warehouses', 'InstallController@download_warehouses');
    Route::get('download_warehouse_locations', 'InstallController@download_warehouse_locations');
    Route::get('download_providers', 'InstallController@download_providers');
    Route::get('download_categories', 'InstallController@download_categories');
    Route::get('download_measurement_units', 'InstallController@download_measurement_units');
    Route::get('download_products', 'InstallController@download_products');
    Route::get('download_accounting', 'InstallController@download_accounting');
    Route::get('download_vehicles', 'InstallController@download_vehicles');
  });
});
