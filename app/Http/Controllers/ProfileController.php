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
      if($inputs['gender_id'] == 1) {
        $bmr = 10 * (int)$inputs['weight'] + 6.25 * (int)$inputs['height'] - 5 * (int)$inputs['age'] + 5;
      } else {
        $bmr = 10 * (int)$inputs['weight'] + 6.25 * (int)$inputs['height'] - 5 * (int)$inputs['age'] - 165;
      }
      // BMR (kcal / day) = 10 * weight (kg) + 6.25 * height (cm) – 5 * age (y) + s (kcal / day),
      // where s is +5 for males and -161 for females.

      if($inputs['activity_id'] == 1) {
        $bmr = $bmr * 1.2;
      } else if($inputs['activity_id'] == 2) {
        $bmr = $bmr * 1.375;
      } else if($inputs['activity_id'] == 3) {
        $bmr = $bmr * 1.55;
      } else if($inputs['activity_id'] == 4) {
        $bmr = $bmr * 1.725;
      } else if($inputs['activity_id'] == 5) {
        $bmr = $bmr * 1.9;
      }
      // 1.2: If you are sedentary (little or no exercise) = BMR x 1.2
      // 1.375: If you are lightly active (light exercise/sports 1-3 days/week) = BMR x 1.375
      // 1.55: If you are moderately active (moderate exercise/sports 3-5 days/week) = BMR x 1.55
      // 1.725: If you are very active (hard exercise/sports 6-7 days a week) = BMR x 1.725
      // 1.9: If you are extra active (very hard exercise/sports & physical job or 2x training) = BMR x 1.9
      $inputs['bmr'] = $bmr;
      $inputs['maintain_weight'] = $bmr;
      $inputs['lose_weight'] = $bmr - 495;
      $inputs['lose_weight_fast'] = $bmr - 990;

      Profile::find($inputs['id'])->update($inputs);
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
}
