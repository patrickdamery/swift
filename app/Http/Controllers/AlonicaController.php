<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Configuration;

class AlonicaController extends Controller
{
  private $alonica_url = 'http://alonica.net';


    public function user() {
      // Check for token.
      $validator = Validator::make(Input::all(),
        array(
          'alonica_token' => 'required'
        )
      );
      if($validator->fails()) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('alonica_controller.blank_token')
        );
        return response()->json($response);
      }

      // Set up curl request to Alonica.
      $curl_request = curl_init($this->alonica_url.'/api/user');
      curl_setopt($curl_request, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept-Type: application/json',
        'Authorization: Bearer '. Input::get('alonica_token')
      ));
      curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);

      // Execute request and get result.
      $output = curl_exec($curl_request);
      $http_result = curl_getinfo($curl_request);
      $bad_codes = array(
        401, 302
      );
      if(in_array($http_result['http_code'], $bad_codes)) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('alonica_controller.no_auth_token')
        );
        return response()->json($response);
      }

      // Get configuration and save key.
      $config = Configuration::find(1);
      $config->auth_key = Input::get('alonica_token');
      $config->modules = json_decode($output)->modules;
      $config->save();

      $response = array(
        'state' => 'Success',
        'modules' => json_decode($output)->modules
      );
      return response()->json($response);
    }
}
