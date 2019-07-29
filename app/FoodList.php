<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FoodList extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'food', 
        'serving_size', 
        'calories',
        'carb',
        'protein',
        'fat',
        'profile_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function userFoodIntake() {
        return $this->hasMany('App\UserFoodIntake');
    }
}
