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

  // Products Routes.
  Route::prefix('products')->group(function() {
    Route::post('suggest_products', 'AccountController@suggest_products');
    Route::post('create_products', 'AccountController@create_product');
    Route::post('load_products', 'AccountController@load_products');
  });

  // Staff Routes.
  Route::prefix('staff')->group(function() {

    // Staff Routes.
    Route::post('suggest_staff', 'StaffController@suggest_worker');
    Route::post('search', 'StaffController@search_worker');
    Route::post('create', 'StaffController@create_worker');
    Route::post('change_name', 'StaffController@change_name');
    Route::post('change_id', 'StaffController@change_id');
    Route::post('change_phone', 'StaffController@change_phone');
    Route::post('change_job', 'StaffController@change_job');
    Route::post('change_state', 'StaffController@change_state');
    Route::post('get_user', 'StaffController@get_user');
    Route::post('create_user', 'StaffController@create_user');
    Route::post('edit_user', 'StaffController@edit_user');
    Route::post('print_staff', 'StaffController@print_staff');

    // Staff Configuration Routes.
    Route::post('search_config', 'StaffConfigurationController@search_config');
    Route::post('save_config', 'StaffConfigurationController@save_config');
    Route::post('search_access', 'StaffConfigurationController@search_access');
    Route::post('change_access', 'StaffConfigurationController@change_access');
    Route::post('create_access', 'StaffConfigurationController@create_access');
  });

  // Vehicle Routes.
  Route::prefix('vehicle')->group(function() {
    Route::post('suggest_vehicle', 'VehicleController@suggest_vehicle');
  });

  // Accounting Routes.
  Route::prefix('accounting')->group(function() {

    // Bank Accounts Routes.
    Route::post('create_bank_account', 'BankAccountController@create_account');
    Route::post('suggest_bank_accounts', 'BankAccountController@suggest_accounts');
    Route::post('search_bank_account', 'BankAccountController@search_bank_account');
    Route::post('create_pos', 'BankAccountController@create_pos');
    Route::post('create_cheque_book', 'BankAccountController@create_cheque_book');
    Route::post('create_loan', 'BankAccountController@create_loan');
    Route::post('get_pos', 'BankAccountController@get_pos');
    Route::post('edit_pos', 'BankAccountController@edit_pos');
    Route::post('get_cheque_book', 'BankAccountController@get_cheque_book');
    Route::post('load_cheques', 'BankAccountController@load_cheques');
    Route::post('edit_cheque_book', 'BankAccountController@edit_cheque_book');
    Route::post('get_loan', 'BankAccountController@get_loan');
    Route::post('edit_loan', 'BankAccountController@edit_loan');
    Route::post('create_cheque', 'BankAccountController@create_cheque');

    // Currency Routes.
    Route::post('create_currency', 'CurrencyController@create_currency');
    Route::post('currency_table', 'CurrencyController@currency_table');
    Route::post('save_local_currency', 'CurrencyController@save_local_currency');
    Route::post('variation_search', 'CurrencyController@variation_search');
    Route::post('change_rate', 'CurrencyController@change_rate');
    Route::post('change_currency_description', 'CurrencyController@change_currency_description');

    // Accounts Routes.
    Route::post('suggest_accounts', 'AccountController@suggest_accounts');
    Route::post('suggest_asset', 'AccountController@suggest_asset');
    Route::post('suggest_liability', 'AccountController@suggest_liability');
    Route::post('suggest_expense', 'AccountController@suggest_expense');
    Route::post('suggest_contra_asset', 'AccountController@suggest_contra_asset');
    Route::post('create_account', 'AccountController@create_account');
    Route::post('load_accounts', 'AccountController@load_accounts');
    Route::post('load_asset', 'AccountController@load_asset');
    Route::post('load_ledger', 'AccountController@load_ledger');
    Route::post('print_ledger', 'AccountController@print_ledger');
    Route::get('download_ledger', 'AccountController@download_ledger');
    Route::post('change_account_name', 'AccountController@change_account_name');
    Route::post('change_ledger_description', 'AccountController@change_ledger_description');
    Route::post('suggest_parent_accounts', 'AccountController@suggest_parent_accounts');
    Route::post('suggest_child_accounts', 'AccountController@suggest_child_accounts');
    Route::post('delete_account', 'AccountController@delete_account');
    Route::post('check_account_code', 'AccountController@check_account_code');

    // Depreciating Assets.
    Route::post('create_depreciating_account', 'DepreciatingAccountsController@create_depreciating_account');
    Route::post('search_depreciating_account', 'DepreciatingAccountsController@search_depreciating_account');
    Route::post('save_depreciating_account', 'DepreciatingAccountsController@save_depreciating_account');

    // Journal Routes.
    Route::post('search_entries', 'JournalController@search_entries');
    Route::post('create_entries', 'JournalController@create_entries');
    Route::post('create_report', 'JournalController@create_report');
    Route::post('generate_report', 'JournalController@generate_report');
    Route::post('print_report', 'JournalController@print_report');
    Route::post('load_report', 'JournalController@load_report');
    Route::post('edit_report', 'JournalController@edit_report');
    Route::post('save_configuration', 'JournalController@save_configuration');
    Route::post('create_graph', 'JournalController@create_graph');
    Route::post('load_graph', 'JournalController@load_graph');
    Route::post('edit_graph', 'JournalController@edit_graph');
    Route::post('make_closing_entry', 'JournalController@make_closing_entry');
    Route::post('generate_graph', 'JournalController@generate_graph');
    Route::get('download_entries', 'JournalController@download_entries');
    Route::get('download_report', 'JournalController@download_report');
  });

  // Configuration Routes.
  Route::prefix('configuration')->group(function() {

    // Group Routes.
    Route::post('suggest_print_group', 'GroupController@suggest_print');
    Route::post('suggest_notification_group', 'GroupController@suggest_notification');
    Route::post('suggest_commission_group', 'GroupController@suggest_commission');
    Route::post('suggest_discount_group', 'GroupController@suggest_discount');
    Route::post('suggest_branch_group', 'GroupController@suggest_branch');
    Route::post('suggest_pos_group', 'GroupController@suggest_pos');
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
    Route::post('depreciating_assets', function() {
        return view('system.modules.accounting.depreciating_assets');
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
