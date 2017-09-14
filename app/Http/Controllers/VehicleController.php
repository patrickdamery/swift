<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Vehicle;
class VehicleController extends Controller
{
  public function suggest_vehicle() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/vehicle_controller.vehicle_data_required')
      );
      return response()->json($response);
    }

    $vehicles = Vehicle::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('make', 'like', '%'.Input::get('code').'%')
      ->orWhere('model', 'like', '%'.Input::get('code').'%')
      ->get();

    $response = array();
    foreach($vehicles as $vehicle) {
      $label = ($vehicle->code == 0) ? $vehicle->make : $vehicle->make.' '.$vehicle->model;
      array_push($response, array(
        'label' => $label,
        'value' => $vehicle->code,
      ));
    }
    return response()->json($response);
  }
}
