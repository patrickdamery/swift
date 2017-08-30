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
  // Check if we have any user defined.
  $users = \App\User::all();
  if(count($users) > 0) {
    if(Auth::check()) {
      return redirect('/swift/system/main');
    } else {
      return redirect('/login');
    }
  } else {
    return view('install.pages.install');
  }
});

Route::post('refresh_token', function() {
  $response = array(
    'state' => 'Success',
    'token' => csrf_token()
  );
  return response()->json($response);
});

Route::get('login', function() {
  if(Auth::check()) {
    return redirect('swift/system/main');
  } else {
    return view('login');
  }
});

Route::get('logout', 'AuthController@logout');

Route::post('login', 'AuthController@authenticate');

Route::prefix('alonica')->group(function() {
  Route::post('user', 'AlonicaController@user');
});

Route::prefix('swift')->group(function() {

  // System routes.
  Route::prefix('system')->group(function() {
    Route::get('main', function() {
      if(Auth::check()) {
        return view('system');
      } else {
        return redirect('login');
      }
    });
    Route::post('profile', function() {
        return view('system.pages.profile');
    });
    // Sales Module Views.
    Route::post('sales', function() {
        return view('system.pages.sales');
    });
    Route::post('orders', function() {
        return view('system.pages.orders');
    });
    Route::post('cashbox', function() {
        return view('system.pages.cashbox');
    });
    Route::post('clients', function() {
        return view('system.pages.clients');
    });
    Route::post('discounts', function() {
        return view('system.pages.discounts');
    });
    Route::post('sales_analytics', function() {
        return view('system.pages.sales_analytics');
    });

    // Products Module Views.
    Route::post('products', function() {
        return view('system.pages.products');
    });
    Route::post('providers', function() {
        return view('system.pages.providers');
    });
    Route::post('categories', function() {
        return view('system.pages.categories');
    });
    Route::post('measurement_units', function() {
        return view('system.pages.measurement_units');
    });
    Route::post('purchases', function() {
        return view('system.pages.purchases');
    });
    Route::post('local_purchases', function() {
        return view('system.pages.local_purchases');
    });
    Route::post('suggestions', function() {
        return view('system.pages.suggestions');
    });

    // warehouse Module Views.
    Route::post('warehouse', function() {
        return view('system.pages.warehouse');
    });
    Route::post('receive_products', function() {
        return view('system.pages.receive_products');
    });
    Route::post('dispatch_products', function() {
        return view('system.pages.dispatch_products');
    });
    Route::post('stock', function() {
        return view('system.pages.stock');
    });
    Route::post('stock_movement', function() {
        return view('system.pages.stock_movement');
    });
    Route::post('product_existance', function() {
        return view('system.pages.product_existance');
    });

    // Staff Module Views.
    Route::post('staff', function() {
        return view('system.pages.staff');
    });
    Route::post('staff_configuration', function() {
        return view('system.pages.staff_configuration');
    });
    Route::post('staff_analytics', function() {
        return view('system.pages.staff_analytics');
    });
    Route::post('staff_payments', function() {
        return view('system.pages.staff_payments');
    });
    Route::post('staff_assistance', function() {
        return view('system.pages.staff_assistance');
    });

    // Vehicles Module Views.
    Route::post('vehicles', function() {
        return view('system.pages.vehicles');
    });
    Route::post('journeys', function() {
        return view('system.pages.journeys');
    });
    Route::post('routes', function() {
        return view('system.pages.routes');
    });

    // Accounting Module Views.
    Route::post('bank_accounts', function() {
        return view('system.pages.bank_accounts');
    });
    Route::post('currency', function() {
        return view('system.pages.currency');
    });
    Route::post('accounts', function() {
        return view('system.pages.accounts');
    });
    Route::post('journal', function() {
        return view('system.pages.journal');
    });

    // Configuration Views.
    Route::post('branch', function() {
        return view('system.pages.branch');
    });
    Route::post('group', function() {
        return view('system.pages.group');
    });
    Route::post('configuration', function() {
        return view('system.pages.configuration');
    });
  });

  // Installation Routes.
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
