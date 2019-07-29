<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserFoodIntake extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'meal_type_id',
        'food_list_id',
        'profile_id' 
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function mealType() {
        return $this->belongsTo('App\MealType');
    }
    public function foodList() {
        return $this->belongsTo('App\FoodList');
    }
}
