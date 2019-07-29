<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MealType;
use App\FoodList;
use App\UserFoodIntake;
use App\Profile;
use App\User;
use DB;
use Auth;

use App\Http\Requests\FoodDiaryRequest;

class FoodDiaryController extends Controller
{
  public function getDatas(Request $request) {
    try {
      $user = Auth::user();
      $data = $request->all();
      $meal_types = MealType::all();
      $food_list = FoodList::where('profile_id', $user['profile_id'])->get();

     
      
      $breakfast = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 1)
      ->where('profile_id', $user['profile_id'])
      ->get();

      $lunch = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 2)
      ->where('profile_id', $user['profile_id'])
      ->get();

      $dinner = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 3)
      ->where('profile_id', $user['profile_id'])
      ->get();

      $snack = UserFoodIntake::with('mealType','foodList')
      ->where('date', $data['date'])
      ->where('meal_type_id', 4)
      ->where('profile_id', $user['profile_id'])
      ->get();

      $total_calories_today = DB::table('user_food_intakes as a')
      ->leftJoin('food_lists as b', 'a.food_list_id', 'b.id')
      ->where('date', $data['date'])
      ->where('a.profile_id', $user['profile_id'])
      ->sum('calories');

      $total_carb_today = DB::table('user_food_intakes as a')
      ->leftJoin('food_lists as b', 'a.food_list_id', 'b.id')
      ->where('date', $data['date'])
      ->where('a.profile_id', $user['profile_id'])
      ->sum('carb');

      $total_fat_today = DB::table('user_food_intakes as a')
      ->leftJoin('food_lists as b', 'a.food_list_id', 'b.id')
      ->where('date', $data['date'])
      ->where('a.profile_id', $user['profile_id'])
      ->sum('fat');

      $total_protein_today = DB::table('user_food_intakes as a')
      ->leftJoin('food_lists as b', 'a.food_list_id', 'b.id')
      ->where('date', $data['date'])
      ->where('a.profile_id', $user['profile_id'])
      ->sum('protein');

      $profile = Profile::where('id', $user['profile_id'])->get();

      $food_intake = array($breakfast, $lunch, $dinner, $snack);
      return compact(
        'meal_types', 
        'food_list', 
        'food_intake', 
        'total_calories_today', 
        'total_carb_today', 
        'total_fat_today', 
        'total_protein_today', 
        'profile');   
    }
    catch(\Exception $ex) {
      return response(['message' => $ex->getMessage()], 500);
    }
  }
  public function add(FoodDiaryRequest $request) {
    try {
      $user = Auth::user();
      $inputs = $request->all();
      $inputs['profile_id'] = $user['profile_id'];
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
