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

  // Accounting Routes.
  Route::prefix('accounting')->group(function() {

    // Currency Routes.
    Route::post('create_currency', 'CurrencyController@create_currency');
    Route::post('currency_table', 'CurrencyController@currency_table');
    Route::post('save_local_currency', 'CurrencyController@save_local_currency');

    // Accounts Routes.
    Route::post('suggest_accounts', 'AccountController@suggest_accounts');
    Route::post('create_account', 'AccountController@create_account');
    Route::post('load_accounts', 'AccountController@load_accounts');
    Route::post('load_ledger', 'AccountController@load_ledger');
    Route::post('print_ledger', 'AccountController@print_ledger');
    Route::get('download_ledger', 'AccountController@download_ledger');
  });

  // products Routes.
  Route::prefix('products')->group(function() {
    Route::post('suggest_products', 'AccountController@suggest_accounts');
    Route::post('create_products', 'AccountController@create_account');
    Route::post('load_products', 'AccountController@load_accounts');
  });

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
        return view('system.modules.general.profile');
    });
    // Sales Module Views.
    Route::post('sales', function() {
        return view('system.modules.sale_product.sales');
    });
    Route::post('cashbox', function() {
        return view('system.modules.sale_product.cashbox');
    });
    Route::post('clients', function() {
        return view('system.modules.sale_product.clients');
    });
    Route::post('discounts', function() {
        return view('system.modules.sale_product.discounts');
    });
    Route::post('sales_analytics', function() {
        return view('system.modules.sale_product.sales_analytics');
    });

    // Products Module Views.
    Route::post('products', function() {
        return view('system.modules.sale_product.products');
    });
    Route::post('providers', function() {
        return view('system.modules.sale_product.providers');
    });
    Route::post('categories', function() {
        return view('system.modules.sale_product.categories');
    });
    Route::post('measurement_units', function() {
        return view('system.modules.sale_product.measurement_units');
    });
    Route::post('purchases', function() {
        return view('system.modules.sale_product.purchases');
    });
    Route::post('local_purchases', function() {
        return view('system.modules.sale_product.local_purchases');
    });
    Route::post('product_existance', function() {
        return view('system.modules.sale_product.product_existance');
    });
    Route::post('suggestions', function() {
        return view('system.modules.sale_product.suggestions');
    });

    // Warehouse Module Views.
    Route::post('warehouse', function() {
        return view('system.modules.warehouse.warehouse');
    });
    Route::post('receive_products', function() {
        return view('system.modules.warehouse.receive_products');
    });
    Route::post('dispatch_products', function() {
        return view('system.modules.warehouse.dispatch_products');
    });
    Route::post('stock', function() {
        return view('system.modules.warehouse.stock');
    });
    Route::post('stock_movement', function() {
        return view('system.modules.warehouse.stock_movement');
    });
    Route::post('orders', function() {
        return view('system.modules.warehouse.orders');
    });

    // Staff Module Views.
    Route::post('staff', function() {
        return view('system.modules.staff.staff');
    });
    Route::post('staff_configuration', function() {
        return view('system.modules.staff.staff_configuration');
    });
    Route::post('staff_analytics', function() {
        return view('system.modules.staff.staff_analytics');
    });
    Route::post('staff_payments', function() {
        return view('system.modules.staff.staff_payments');
    });
    Route::post('staff_assistance', function() {
        return view('system.modules.staff.staff_assistance');
    });

    // Vehicles Module Views.
    Route::post('vehicles', function() {
        return view('system.modules.vehicle.vehicles');
    });
    Route::post('journeys', function() {
        return view('system.modules.vehicle.journeys');
    });
    Route::post('routes', function() {
        return view('system.modules.vehicle.routes');
    });

    // Accounting Module Views.
    Route::post('bank_accounts', function() {
        return view('system.modules.accounting.bank_accounts');
    });
    Route::post('currency', function() {
        return view('system.modules.accounting.currency');
    });
    Route::post('accounts', function() {
        return view('system.modules.accounting.accounts');
    });
    Route::post('journal', function() {
        return view('system.modules.accounting.journal');
    });

    // Configuration Views.
    Route::post('branch', function() {
        return view('system.modules.configuration.branch');
    });
    Route::post('group', function() {
        return view('system.modules.configuration.group');
    });
    Route::post('configuration', function() {
        return view('system.modules.configuration.configuration');
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
