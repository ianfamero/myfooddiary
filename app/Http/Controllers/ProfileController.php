<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gender;
use App\Activity;
use App\Profile;

class ProfileController extends Controller
{
  public function getDatas() {
    try {
      $genders = Gender::all();
      $activity = Activity::all();
      $profile = Profile::where('id', 1)->get();
      return compact('genders', 'activity', 'profile');
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }

  public function save(Request $request) {
    try {
      $inputs = $request->all();

      // COMPUTATION HERE

      $inputs['maintain_weight'] = 100;
      $inputs['lose_weight'] = 100;
      $inputs['lose_weight_fast'] = 100;

      Profile::find($inputs['id'])->update($inputs);
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
}
