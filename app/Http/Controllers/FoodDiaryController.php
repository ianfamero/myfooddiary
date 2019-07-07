<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MealType;
use App\FoodList;
use App\UserFoodIntake;
use App\Profile;
use DB;

class FoodDiaryController extends Controller
{
  public function getDatas(Request $request) {
    try {
      $data = $request->all();
      $meal_types = MealType::all();
      $food_list = FoodList::all();

      $breakfast = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 1)
      ->get();

      $lunch = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 2)
      ->get();

      $dinner = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 3)
      ->get();

      $snack = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 4)
      ->get();

      $total_calories_today = DB::table('user_food_intakes as a')
      ->leftJoin('food_lists as b', 'a.food_list_id', 'b.id')
      ->where('date', $data['date'])
      ->sum('calories');

      $profile = Profile::where('id', 1)->get();

      $food_intake = array($breakfast, $lunch, $dinner, $snack);
      return compact('meal_types', 'food_list', 'food_intake', 'total_calories_today', 'profile');   
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
  public function add(Request $request) {
    try {
      $inputs = $request->all();
      $user_food_intake = UserFoodIntake::create($inputs);
      return response(['message' => config('global.success-store'), 'user_food_intake' => $user_food_intake], 200);
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
  public function destroy($id) {
    try {
      UserFoodIntake::destroy($id);
      return config('global.success-delete');
    } 
    catch (\Exception $ex) {

    }
  }
}
