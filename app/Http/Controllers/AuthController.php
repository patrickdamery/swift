<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Worker;
class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
      // Validate Input.
      $validator = Validator::make(Input::all(),
          array(
              'username' => 'required',
              'password' => 'required'
              )
          );
      if($validator->fails()) {
          return redirect('/login')->with('message', \Lang::get('controllers/auth_controller.login_error'));
      }

      // Extract user salt.
      $user = User::where('username', '=', Input::get('username'))->first();

      // Check if we found the user.
      if(!isset($user)) {
          return redirect('/login')->with('message', \Lang::get('controllers/auth_controller.login_error'));
      }

      // Check if user doesn't belong to an unactive worker.
      $worker = Worker::withTrashed()->where('code', $user->worker_code)->first();
      if($worker->state == 2) {
        return redirect('/login')->with('message', \Lang::get('controllers/auth_controller.login_error'));
      }

      // Attempt to authenticate.
      if (Auth::attempt(array('username' => Input::get('username'),
                              'password' => Input::get('password').$user->salt), 1)) {
          return redirect()->intended('/swift/system/main');
      } else {
          return redirect('/login')->with('message', \Lang::get('controllers/auth_controller.login_error'));
      }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
