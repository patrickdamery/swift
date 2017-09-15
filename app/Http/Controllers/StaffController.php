<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use \App\Worker;
class StaffController extends Controller
{
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
      'error' => \Lang::get('controllers/staff_controller.name_changed')
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
      'error' => \Lang::get('controllers/staff_controller.name_changed')
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
      'error' => \Lang::get('controllers/staff_controller.name_changed')
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
      'error' => \Lang::get('controllers/staff_controller.name_changed')
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
      'error' => \Lang::get('controllers/staff_controller.name_changed')
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
    $worker_check = Worker::where('legal_id', Input::get('legal_id'))->first();
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
      $last_worker = Worker::orderBy('id', 'desc')->first();

      // Create worker.
      $worker = Worker::create(array(
        'code' => $last_worker->code+1,
        'name' => Input::get('name'),
        'legal_id' => Input::get('id'),
        'job_title' => Input::get('job_title'),
        'phone' => Input::get('phone'),
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
