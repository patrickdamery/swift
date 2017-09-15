<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Group;
class GroupController extends Controller
{
  public function suggest_print() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/group_controller.code_required')
      );
      return response()->json($response);
    }

    // Get group suggestions.
    $groups = Group::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $groups = $groups->where('type', 2);

    $response = array();
    foreach($groups as $group) {
      array_push($response, array(
        'label' => $group->name,
        'value' => $group->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_commission() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/group_controller.code_required')
      );
      return response()->json($response);
    }

    // Get group suggestions.
    $groups = Group::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $groups = $groups->where('type', 8);

    $response = array();
    foreach($groups as $group) {
      array_push($response, array(
        'label' => $group->name,
        'value' => $group->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_discount() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/group_controller.code_required')
      );
      return response()->json($response);
    }

    // Get group suggestions.
    $groups = Group::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $groups = $groups->where('type', 7);

    $response = array();
    foreach($groups as $group) {
      array_push($response, array(
        'label' => $group->name,
        'value' => $group->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_branch() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/group_controller.code_required')
      );
      return response()->json($response);
    }

    // Get group suggestions.
    $groups = Group::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $groups = $groups->where('type', 1);

    $response = array();
    foreach($groups as $group) {
      array_push($response, array(
        'label' => $group->name,
        'value' => $group->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_pos() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/group_controller.code_required')
      );
      return response()->json($response);
    }

    // Get group suggestions.
    $groups = Group::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $groups = $groups->where('type', 9);

    $response = array();
    foreach($groups as $group) {
      array_push($response, array(
        'label' => $group->name,
        'value' => $group->code,
      ));
    }
    return response()->json($response);
  }
}
