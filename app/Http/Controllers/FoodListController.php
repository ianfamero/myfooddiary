<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodList;
use Auth;

use App\Http\Requests\FoodListRequest;

class FoodListController extends Controller
{
  public function getDatas() {
    try {
      $user = Auth::user();
      $food_list = FoodList::where('profile_id', $user['profile_id'])->get();

      return $food_list;
    }
    catch(\Exception $ex) {
        
    }
  }
  public function store(FoodListRequest $request) {
    try {
      $user = Auth::user();
      $inputs = $request->all();
      $inputs['profile_id'] = $user['profile_id'];
      $food_list = FoodList::create($inputs);
      // return $food_list;
      return response(['message' => config('global.success-store'), 'food_list' => $food_list], 200);
    }
    catch(\Exception $ex) {

    }
  }
  public function update($id, FoodListRequest $request) {
    try {
      $inputs = $request->all();
      FoodList::find($id)->update($inputs);
      return response(['message' => config('global.success-update')], 200);
    }
    catch(\Exception $ex) {

    }
  }
  public function destroy($id) {
    try {
      FoodList::destroy($id);
      return config('global.success-delete');
    } 
    catch (\Exception $ex) {

    }
  }

  public function destroySelected(Request $request) {
    try {
      FoodList::destroy($request->all());
      return config('global.success-mult-delete');
    } 
    catch (\Exception $ex) {

    }
  }
}
