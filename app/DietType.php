<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DietType extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diet', 
        'percent_carbs', 
        'percent_fats',
        'percent_proteins',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function profile() {
        return $this->hasMany('App\Profile');
    }
}
