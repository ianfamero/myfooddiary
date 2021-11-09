<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodList;
use Auth;

class NutritionixController extends Controller
{
  public function search(Request $request) {
    $input = $request->all();  
    // $url = "https://api.nutritionix.com/v1_1/search/".urlencode($input['searchQuery'])."?results=0:50&fields=item_name,brand_name,nf_calories,nf_total_fat,nf_total_carbohydrate,nf_protein,nf_serving_size_qty,nf_serving_size_unit&appId=4decda58&appKey=9668aaaea93d81038720d848fa1065ed";
    // $result = file_get_contents($url);
    // $results = json_decode($result, true);
    // $search_results = [];
    // foreach($results['hits'] as $result) {
    //   $search_results[] = array(
    //     'food' => $result['fields']['item_name'] . ' (' . $result['fields']['brand_name'] . ')',
    //     'serving_size' => $result['fields']['nf_serving_size_qty'] . ' ' . $result['fields']['nf_serving_size_unit'],
    //     'calories' => $result['fields']['nf_calories'],
    //     'carb' => $result['fields']['nf_total_carbohydrate'],
    //     'fat' => $result['fields']['nf_total_fat'],
    //     'protein' => $result['fields']['nf_protein']
    //   );
    // }
    // return $search_results;
    $url = "https://api.nal.usda.gov/ndb/search/?format=json&ds=Standard%20Reference&q=".urlencode($input['searchQuery'])."&sort=n&max=25&offset=0&api_key=OAnc7ObDIUOiBHfRBdJLegY41PPEKroYUoGxqNyw";
    $get_results = file_get_contents($url);
    $results = json_decode($get_results, true);
    $search_results = [];
    foreach($results['list']['item'] as $item) {
      $url = "https://api.nal.usda.gov/ndb/nutrients/?format=json&ndbno=".$item['ndbno']."&api_key=OAnc7ObDIUOiBHfRBdJLegY41PPEKroYUoGxqNyw&nutrients=208&nutrients=203&nutrients=204&nutrients=205";
      $get_nutrients = file_get_contents($url);
      $nutrients = json_decode($get_nutrients, true);
      // return $nutrients['report']['foods'][0]['nutrients'][0]['value'];
      $search_results[] = array(
        'food' => $nutrients['report']['foods'][0]['name'],
        'serving_size' => $nutrients['report']['foods'][0]['measure'],
        'calories' => @$nutrients['report']['foods'][0]['nutrients'][0]['value'],
        'carb' => @$nutrients['report']['foods'][0]['nutrients'][3]['value'],
        'fat' => @$nutrients['report']['foods'][0]['nutrients'][2]['value'],
        'protein' => @$nutrients['report']['foods'][0]['nutrients'][1]['value']
      );
    }
    return $search_results;
  }
  public function store(Request $request) {
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
}
