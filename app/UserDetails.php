<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'user_id', 'employee_no', 'mobile', 'joining_date', 'dob', 'bank', 'account_no', 'pan', 'designation', 'salary_details', 'weekend_off', 'earn_leave' 
    ];

    /*public function details()
    {
        return $this->belongsTo('App\User');
    }*/

    public function getSalaryDetailsAttribute($value)
    {
        return $value
                    ? json_decode($value)
                    : json_decode(json_encode(\Config::get('settings.salary')));    }
}
