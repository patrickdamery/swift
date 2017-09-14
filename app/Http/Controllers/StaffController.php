<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use \App\Worker;
class StaffController extends Controller
{
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
