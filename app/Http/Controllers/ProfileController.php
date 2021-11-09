<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gender;
use App\Activity;
use App\Profile;
use App\User;
use App\DietType;
use Auth;

use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
  public function getDatas() {
    try {
      $user = Auth::user();
      $genders = Gender::all();
      $activity = Activity::all();
      $diet_types = DietType::all();
      $profile = User::with('profile','profile.diet')->where('profile_id', $user['profile_id'])->get();
      
      if($profile[0]->profile->diet_type_id != 0) {
        $percent_carbs = $profile[0]->profile->diet->percent_carbs / 100;
        $percent_fats = $profile[0]->profile->diet->percent_fats / 100;
        $percent_proteins = $profile[0]->profile->diet->percent_proteins / 100;
      } else {
        $percent_carbs = 0;
        $percent_fats = 0;
        $percent_proteins = 0;
      }
      $summary[0] = [
        "target" => "Lose Weight Fast",
        "calories" => $profile[0]->profile->lose_weight_fast, 
        "carb" => round(($profile[0]->profile->lose_weight_fast * $percent_carbs) / 4), 
        "protein" => round(($profile[0]->profile->lose_weight_fast * $percent_proteins) / 4), 
        "fat" => round(($profile[0]->profile->lose_weight_fast * $percent_fats) / 9), 
      ];
      $summary[1] = [
        "target" => "Lose Weight",
        "calories" => $profile[0]->profile->lose_weight, 
        "carb" => round(($profile[0]->profile->lose_weight * $percent_carbs) / 4), 
        "protein" => round(($profile[0]->profile->lose_weight * $percent_proteins) / 4), 
        "fat" => round(($profile[0]->profile->lose_weight * $percent_fats) / 9), 
      ];
      $summary[2] = [
        "target" => "Maintain Weight",
        "calories" => $profile[0]->profile->maintain_weight, 
        "carb" => round(($profile[0]->profile->maintain_weight * $percent_carbs) / 4), 
        "protein" => round(($profile[0]->profile->maintain_weight * $percent_proteins) / 4), 
        "fat" => round(($profile[0]->profile->maintain_weight * $percent_fats) / 9), 
      ];
      
      

      return compact('genders', 'activity', 'profile', 'summary', 'diet_types');
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }

  public function save(ProfileRequest $request) {
    try {
      $inputs = $request->all();

      if($inputs['gender_id'] == 1) {
        $bmr = 10 * (int)$inputs['weight'] + 6.25 * (int)$inputs['height'] - 5 * (int)$inputs['age'] + 5;
      } else {
        $bmr = 10 * (int)$inputs['weight'] + 6.25 * (int)$inputs['height'] - 5 * (int)$inputs['age'] - 165;
      }
      // BMR (kcal / day) = 10 * weight (kg) + 6.25 * height (cm) – 5 * age (y) + s (kcal / day),
      // where s is +5 for males and -161 for females.
      
      $inputs['bmr'] = $bmr;

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
      
      $inputs['maintain_weight'] = $bmr;
      $inputs['lose_weight'] = $bmr - 495;
      $inputs['lose_weight_fast'] = $bmr - 990;

      Profile::find($inputs['id'])->update($inputs);
      return response(['message' => 'Profile saved successfully.'], 200);
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
}
