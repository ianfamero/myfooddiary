<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profile extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gender_id', 
        'age', 
        'height',
        'weight',
        'activity_id',
        'maintain_weight',
        'lose_weight',
        'lose_weight_fast',
        'bmr'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function gender() {
        return $this->belongsTo('App\Gender');
    }
    public function activity() {
        return $this->belongsTo('App\Activity');
    }
}
