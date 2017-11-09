<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use \App\Worker;
use \App\WorkerSetting;
use \App\User;
class StaffController extends Controller
{
  public function print_staff() {
    return view('system.printables.staff.staff_list',
     [
       'code' => Input::get('code'),
       'branch' => Input::get('branch')
    ]);
  }

  public function create_user() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    // Get the user.
    $user = User::where('username', Input::get('username'))->first();
    if($user) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.username_exists')
      );
      return response()->json($response);
    }
    $user = User::where('email', Input::get('email'))->first();
    if($user) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.email_exists')
      );
      return response()->json($response);
    }
    $user = User::where('worker_code', Input::get('code'))->first();
    if($user) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.worker_has_user')
      );
      return response()->json($response);
    }

    // Create the user.
    $last_user = User::orderBy('code', 'desc')->first();
    $code = ($last_user) ? $last_user->code : 0;

    $salt = uniqid();
    $user = User::create(array(
      'code' => $code+1,
      'worker_code' => Input::get('code'),
      'user_access_code' => '0',
      'username' => Input::get('username'),
      'email' => Input::get('email'),
      'password' => bcrypt(Input::get('password').$salt),
      'salt' => $salt,
      'theme' => 'default',
    ));

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.user_created')
    );
    return response()->json($response);
  }

  public function edit_user() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'username' => 'required',
        'email' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    // Get the user.
    $user = User::where('worker_code', Input::get('code'))->first();
    if(!$user) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.user_not_found')
      );
      return response()->json($response);
    }

    $user->username = Input::get('username');
    $user->email = Input::get('email');

    if(Input::get('password') != '') {
      $salt = uniqid();
      $user->password = bcrypt(Input::get('password').$salt);
      $user->salt = $salt;
    }
    $user->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.user_updated')
    );
    return response()->json($response);
  }

  public function get_user() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    // Get the user.
    $user = User::where('worker_code', Input::get('code'))->first();
    if(!$user) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.user_not_found')
      );
      return response()->json($response);
    }

    $response = array(
      'state' => 'Success',
      'user' => $user
    );
    return response()->json($response);
  }

  public function change_name() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->name = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_id() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->legal_id = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_phone() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->phone = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_job() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->job_title = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_inss() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->inss = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_address() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->address = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function change_configuration() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $config_test = WorkerSetting::where('id', Input::get('value'))->first();
    if(!$config_test) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.unexistent_configuration_code')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->configuration_code = Input::get('value');
    $worker->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function load_configurations() {

    $configurations = WorkerSetting::all();

    $response = array(
      'state' => 'Success',
      'configs' => $configurations
    );
    return response()->json($response);
  }

  public function change_state() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'value' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $worker = Worker::where('code', Input::get('code'))->first();
    $worker->state = Input::get('value');
    $worker->save();

    if(Input::get('value') == 2) {
      $worker->delete();
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/staff_controller.changed')
    );
    return response()->json($response);
  }

  public function create_worker() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'id' => 'required',
        'job_title' => 'required',
        'phone' => 'required',
        'branch' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    // Check if worker with id doesn't already exist.
    $worker_check = Worker::withTrashed()->where('legal_id', Input::get('id'))->first();
    if($worker_check) {
      if($worker_check->state == 2) {
        $worker_check->restore();
        $worker_check->state = 1;
        $worker_check->save();

        $response = array(
          'state' => 'Success',
          'message' => \Lang::get('controllers/staff_controller.updated_worker')
        );
        return response()->json($response);
      }
    }

    try {
      $last_worker = Worker::withTrashed()->orderBy('id', 'desc')->first();
      $code = ($last_worker) ? $last_worker->code : 0;
      // Create worker.
      $worker = Worker::create(array(
        'code' => ($code+1),
        'name' => Input::get('name'),
        'legal_id' => Input::get('id'),
        'job_title' => Input::get('job_title'),
        'phone' => Input::get('phone'),
        'address' => Input::get('address'),
        'inss' => Input::get('inss'),
        'configuration_code' => Input::get('config'),
        'state' => 1,
        'current_branch_code' => Input::get('branch')
       ));
     } catch(\Exception $e) {
       $response = array(
         'state' => 'Error',
         'error' => \Lang::get('controllers/staff_controller.db_exception'),
       );
       return response()->json($response);
     }

     $response = array(
       'state' => 'Success',
       'message' => \Lang::get('controllers/staff_controller.created_worker')
     );
     return response()->json($response);
  }

  public function search_worker() {
    $validator = Validator::make(Input::all(),
      array(
        'branch' => 'required',
        'offset' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.data_required')
      );
      return response()->json($response);
    }

    $code = (Input::get('code') !== null) ? Input::get('code') : '';

    // Return view.
    return view('system.components.staff.staff_table',
     [
       'code' => Input::get('code'),
       'branch' => Input::get('branch'),
       'offset' => Input::get('offset')
    ]);
  }

  public function suggest_worker() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/staff_controller.code_required')
      );
      return response()->json($response);
    }

    $workers = Worker::where('code', 'like', '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $response = array();
    foreach($workers as $worker) {
      array_push($response, array(
        'label' => $worker->name,
        'value' => $worker->code,
      ));
    }
    return response()->json($response);
  }
}
