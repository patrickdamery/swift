<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use Auth;
use DB;
use \App\WorkerSetting;
use \App\WorkerAccount;
use \App\Worker;
use \App\UserAccess;
use \App\Group;
class StaffConfigurationController extends Controller
{
  public function create_access() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.name_required')
      );
      return response()->json($response);
    }

    // Make user access.
    $user_access = null;
    try {
      $last_access = UserAccess::orderBy('id', 'desc')->first();

      $code = $last_access->code+1;

      $user_access = UserAccess::create(array(
        'code' => $code,
        'name' => Input::get('name'),
        'access' => '{"sales": {"has": 0, "sales": {"has": 0, "make_sale": {"has": 0, "points": 0, "quotation": 0}, "make_reservation": {"has": 0}, "make_subscription": {"has": 0}}, "orders": {"has": 0, "load_order": {"has": 0, "save": 0}, "make_order": {"has": 0}, "view_order": {"has": 0, "print": 0, "make_sale": 0}}, "cashbox": {"has": 0, "cashbox": {"has": 0, "bank_deposit": 0}, "transactions": {"has": 0, "search_bill": 0}, "print_requests": {"has": 0, "pay": 0}}, "clients": {"has": 0, "debts": {"has": 0, "print": 0}, "discounts": {"has": 0, "save": 0}, "view_client": {"has": 0, "save": 0, "create": 0}, "purchase_history": {"has": 0, "print": 0}}, "discounts": {"has": 0, "discounts": {"has": 0, "create": 0}}, "sales_analytics": {"has": 0}}, "staff": {"has": 0, "view_staff": {"has": 0, "view_staff": {"has": 0, "print": 0, "create": 0}}, "staff_config": {"has": 0, "view_config": {"has": 0, "general_config": 0, "accounting_config": 0}, "access_config": {"has": 0, "create": 0, "search": 0}}, "staff_payments": {"has": 0, "view_staff": {"has": 0, "loan": 0, "hour_add": 0}, "past_payments": {"has": 0}, "group_payments": {"has": 0, "pay": 0, "print": 0, "download": 0}}, "staff_analytics": {"has": 0, "view_analytics": {"has": 0}}, "staff_assistance": {"has": 0, "view_entries": {"has": 0, "print": 0, "download": 0}, "view_schedule": {"has": 0, "print": 0, "create": 0}}}, "products": {"has": 0, "providers": {"has": 0, "view_providers": {"has": 0, "save": 0, "create": 0}}, "purchases": {"has": 0, "view_purchases": {"has": 0, "print": 0}}, "categories": {"has": 0, "view_categories": {"has": 0, "create": 0}}, "suggestions": {"has": 0, "make_suggestion": {"has": 0, "save": 0, "print": 0, "generate": 0}}, "view_products": {"has": 0, "view_products": {"has": 0, "edit": 0, "create": 0}, "view_services": {"has": 0, "edit": 0, "create": 0}}, "local_purchases": {"has": 0, "purchase": {"has": 0, "pay": 0}}, "measurement_units": {"has": 0, "view_measurement_units": {"has": 0, "create": 0, "create_conversion": 0}}, "international_order": {"has": 0, "add_bill": {"has": 0}, "view_order": {"has": 0}, "importation_expense": {"has": 0}}}, "vehicles": {"has": 0, "view_routes": {"has": 0, "view_routes": {"has": 0, "create": 0}}, "view_vehicle": {"has": 0, "view_vehicle": {"has": 0, "create": 0}}, "view_journeys": {"has": 0, "view_journeys": {"has": 0, "create": 0}}}, "accounting": {"has": 0, "journal": {"has": 0, "view_entries": {"has": 0, "print": 0, "create": 0, "download": 0}}, "accounts": {"has": 0, "view_ledger": {"has": 0, "print": 0, "download": 0}, "view_accounts": {"has": 0, "create": 0}}, "currency": {"has": 0, "view_currency": {"has": 0, "save": 0, "create": 0}, "view_variation": {"has": 0}}, "bank_accounts": {"has": 0, "pos": {"has": 0, "create": 0}, "bank_loans": {"has": 0, "pay": 0, "loan": 0}, "view_accounts": {"has": 0, "create": 0, "transaction": 0}}}, "warehouses": {"has": 0, "stock": {"has": 0, "stocktake": {"has": 0, "check": 0, "print": 0, "in_system": 0}, "stocktake_report": {"has": 0}}, "receive": {"has": 0, "receive": {"has": 0}}, "dispatch": {"has": 0, "dispatch": {"has": 0}}, "warehouse": {"has": 0, "view_locations": {"has": 0, "print": 0, "create": 0}, "view_warehouse": {"has": 0, "create": 0}}, "stock_movement": {"has": 0, "stock_movement": {"has": 0, "print": 0, "download": 0}}}, "configuration": {"has": 0, "groups": {"has": 0, "view_group": {"has": 0, "create": 0}}, "branches": {"has": 0, "view_branch": {"has": 0, "save": 0, "create": 0}, "public_services": {"has": 0, "create": 0}}, "configuration": {"has": 0, "view_config": {"has": 0, "save": 0}, "modules_plugins": {"has": 0, "save": 0, "backup": 0, "update": 0, "generate": 0}}}}'
      ));
    } catch(\Exception $e) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.db_exception'),
      );
      return response()->json($response);
    }

    $response = array(
      'state' => 'Success',
      'access' => $user_access,
      'message' => \Lang::get('controllers/staff_configuration_controller.access_created'),
    );
    return response()->json($response);
  }

  public function change_access() {
    $validator = Validator::make(Input::all(),
      array(
        'access_code' => 'required',
        'choice' => 'required',
        'path_to' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.access_change_required')
      );
      return response()->json($response);
    }

    // Get the user access.
    $user_access = UserAccess::where('code', Input::get('access_code'))->first();
    $access = json_decode($user_access->access, true);

    // Make the change and save it.
    $indexes = count(Input::get('path_to'));
    switch($indexes) {
      case 2:
        $access[Input::get('path_to')[0]][Input::get('path_to')[1]] = Input::get('choice');
      break;
      case 3:
        $access[Input::get('path_to')[0]][Input::get('path_to')[1]][Input::get('path_to')[2]] = Input::get('choice');
      break;
      case 4:
        $access[Input::get('path_to')[0]][Input::get('path_to')[1]][Input::get('path_to')[2]][Input::get('path_to')[3]] = Input::get('choice');
      break;
    }
    $user_access->access = json_encode($access);
    $user_access->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_configuration_controller.access_changed'),
    );
    return response()->json($response);
  }

  public function search_access() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.code_required')
      );
      return response()->json($response);
    }

    // Get access table.
    return view('system.components.staff.access_table',
      [
        'code' => Input::get('code')
      ]
    );
  }

  public function search_config() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.code_required')
      );
      return response()->json($response);
    }

    // Get current user's access.
    $access = UserAccess::where('code', Auth::user()->user_access_code)->first()->access;
    $access = json_decode($access);
    $settings = '';
    $accounts = '';

    if($access->staff->staff_config->view_config->accounting_config) {
      $accounts = WorkerAccount::where('worker_code', Input::get('code'))->first();

      if(!$accounts) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/staff_configuration_controller.unknown')
        );
        return response()->json($response);
      }
      $accounts->reimbursement_accounts = json_decode($accounts->reimbursement_accounts);
      $accounts->draw_accounts = json_decode($accounts->draw_accounts);
      $accounts->bank_accounts = json_decode($accounts->bank_accounts);
    }
    if($access->staff->staff_config->view_config->general_config) {
      $settings = WorkerSetting::where('worker_code', Input::get('code'))->first();
    }
    $response = array(
      'state' => 'Success',
      'settings' => $settings,
      'accounts' => $accounts,
      'access' => Auth::user()->user_access_code
    );

    return response()->json($response);
  }

  public function save_config() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'accounts' => 'required',
        'settings' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_configuration_controller.configuration_required')
      );
      return response()->json($response);
    }

    // Get user's access.
    $access = UserAccess::where('code', Auth::user()->user_access_code)->first()->access;
    $access = json_decode($access);

    // TODO: Make sure groups exist.
    if($access->staff->staff_config->view_config->general_config) {
      // Get settings and save them.
      $settings = WorkerSetting::where('worker_code', Input::get('code'))->first();
      $settings->hourly_rate = Input::get('settings')['hourly_rate'];
      $settings->vehicle_code = Input::get('settings')['vehicle_code'];
      $settings->schedule_code = Input::get('settings')['schedule_code'];

      // Make sure all groups exist.
      $notification_group = Group::where('code', Input::get('settings')['notification_group'])->first();
      $print_group = Group::where('code', Input::get('settings')['print_group'])->first();
      $commission_group = Group::where('code', Input::get('settings')['commission_group'])->first();
      $discount_group = Group::where('code', Input::get('settings')['discount_group'])->first();
      $branches_group = Group::where('code', Input::get('settings')['branches_group'])->first();
      $pos_group = Group::where('code', Input::get('settings')['pos_group'])->first();

      if(!$notification_group || !$print_group || !$commission_group || !$discount_group ||
       !$branches_group || !$pos_group) {
         $response = array(
           'state' => 'Error',
           'error' => \Lang::get('controllers/staff_configuration_controller.innexistent_group')
         );
         return response()->json($response);
      }

      $settings->notification_group = Input::get('settings')['notification_group'];
      $settings->self_print = Input::get('settings')['self_print'];
      $settings->print_group = Input::get('settings')['print_group'];
      $settings->commission_group = Input::get('settings')['commission_group'];
      $settings->discount_group = Input::get('settings')['discount_group'];
      $settings->branches_group = Input::get('settings')['branches_group'];
      $settings->pos_group = Input::get('settings')['pos_group'];
      $settings->save();

      $user = Auth::user();
      $user->user_access_code = Input::get('access');
      $user->save();
    }
    if($access->staff->staff_config->view_config->accounting_config) {
      $accounts = WorkerAccount::where('worker_code', Input::get('code'))->first();
      $accounts->cashbox_account = Input::get('accounts')['cashbox_account'];
      $accounts->stock_account = Input::get('accounts')['stock_account'];
      $accounts->loan_account = Input::get('accounts')['loan_account'];
      $accounts->long_loan_account = Input::get('accounts')['long_loan_account'];
      $accounts->salary_account = Input::get('accounts')['salary_account'];
      $accounts->commission_account = Input::get('accounts')['commission_account'];
      $accounts->bonus_account = Input::get('accounts')['bonus_account'];
      $accounts->antiquity_account = Input::get('accounts')['antiquity_account'];
      $accounts->holidays_account = Input::get('accounts')['holidays_account'];
      $accounts->savings_account = Input::get('accounts')['savings_account'];
      $accounts->insurance_account = Input::get('accounts')['insurance_account'];

      $reimbursement_accounts = array();
      if(isset(Input::get('accounts')['reimbursement_accounts'])) {
        $reimbursement_accounts = Input::get('accounts')['reimbursement_accounts'];
      }
      $accounts->reimbursement_accounts = json_encode($reimbursement_accounts);

      $draw_accounts = array();
      if(isset(Input::get('accounts')['draw_accounts'])) {
        $draw_accounts = Input::get('accounts')['draw_accounts'];
      }
      $accounts->draw_accounts = json_encode($draw_accounts);

      $bank_accounts = array();
      if(isset(Input::get('accounts')['bank_accounts'])) {
        $draw_accounts = Input::get('accounts')['bank_accounts'];
      }
      $accounts->bank_accounts = json_encode($bank_accounts);
      $accounts->save();
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_configuration_controller.configuration_saved')
    );
    return response()->json($response);
  }
}
