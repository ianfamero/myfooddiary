<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodList;

class FoodListController extends Controller
{
  public function getDatas() {
    try {
      $food_list = FoodList::all();

      return $food_list;
    }
    catch(\Exception $ex) {
        
    }
  }
  public function store(Request $request) {
    try {
      $inputs = $request->all();
      $food_list = FoodList::create($inputs);
      return response(['message' => config('global.success-store'), 'food_list' => $food_list], 200);
    }
    catch(\Exception $ex) {

    }
  }
  public function update($id, Request $request) {
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
