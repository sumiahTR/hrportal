<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class Request extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'starting_date', 'ending_date', 'reason', 'remarks', 'status', 'leave_type_id', 'days','num_of_daysapproved','days_approved'
    ];



    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->withDefault();
    }

    public function leaveType()
    {
        return $this->hasOne('App\Leave', 'id', 'leave_type_id')->withDefault(function ($leaveType, $request) {
            if($request->leave_type_id == 5) {
                $leaveType->leave_type = 'Earn Leave';
            }
            else {
                $leaveType->leave_type = 'Weekend Off';
            }
        });
    }

    public function updatedby()
    {
        return $this->hasOne('App\User', 'id', 'updated_by')->withDefault();
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

    public static function usedWeekendOffCount($id = null) {
        if(is_null($id)) {
            $id = Auth::user()->id;
        }

        return DB::table('requests')->where('leave_type_id', 0)
                ->where('user_id', $id)
                ->where('status', '!=', 'rejected')
                ->whereYear('starting_date', date('Y'))
                ->whereNull('deleted_at')
                ->sum('days');
    }

    //Earn leave type id is 5 @hard coded
    public static function usedEarnLeaveCount($id = null) {
        if(is_null($id)) {
            $id = Auth::user()->id;
        }

        return DB::table('requests')->where('leave_type_id', 5)
                ->where('user_id', $id)
                ->where('status', '!=', 'rejected')
                ->whereYear('starting_date', date('Y'))
                ->whereNull('deleted_at')
                ->sum('days');
    }
}
