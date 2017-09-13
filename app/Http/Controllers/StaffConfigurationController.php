<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use Auth;
use \App\WorkerSetting;
use \App\WorkerAccount;
use \App\Worker;
use \App\UserAccess;
class StaffConfigurationController extends Controller
{
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

    if($access->staff->staff_config->view_config->general_config) {
      // Get settings and save them.
      $settings = WorkerSetting::where('worker_code', Input::get('code'))->first();
      $settings->hourly_rate = Input::get('settings')['hourly_rate'];
      $settings->vehicle_code = Input::get('settings')['vehicle_code'];
      $settings->schedule_code = Input::get('settings')['schedule_code'];
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
