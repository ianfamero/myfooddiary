<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MealType extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meal_type', 
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function userFoodIntake() {
        return $this->hasMany('App\UserFoodIntake');
    }
}
