<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;

use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
  public function register(RegisterRequest $request) {
    try {
      $inputs = $request->all();

      $profile = Profile::create();
      $inputs['password'] = bcrypt($inputs['password']);
      $inputs['profile_id'] = $profile['id'];
      $user = User::create($inputs);
      
      return response(['message' => config('global.success-register'), 'user' => $user], 200);
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500); 
    }
  }
}
