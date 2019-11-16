<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Request extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'starting_date', 'ending_date', 'reason', 'remarks', 'status', 'leave_type_id', 'days',
    ];



    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->withDefault();
    }

    public function leaveType()
    {
        return $this->hasOne('App\Leave', 'id', 'leave_type_id')->withDefault();
    }

    /*public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::user()->id;
    }*/

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->user_id = auth()->id();
        });
    }
}
