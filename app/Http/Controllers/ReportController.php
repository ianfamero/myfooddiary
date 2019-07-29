<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFoodIntake;
use Auth;
use DB;

class ReportController extends Controller
{
  public function generate(Request $request) {
    $user = Auth::user();
    $inputs = $request->all();

    $summary = DB::table('user_food_intakes as a')
    ->join('food_lists as b', 'b.id', 'a.food_list_id')
    ->selectRaw('
        a.date as date, 
        SUM(calories) as calories, 
        SUM(carb) as carb, 
        SUM(fat) as fat, 
        SUM(protein) as protein
    ')->where('a.profile_id', $user['profile_id'])
    ->whereBetween('date', [$inputs['date_from'], $inputs['date_to']])
    ->groupBy('date')
    ->orderBy('date', 'DESC')
    ->get();

    return $summary;
  }
}
