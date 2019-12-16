<?php

namespace App\Http\Controllers\Employee;

use App\Leave;
use App\Request as LeaveRequest;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$requests = LeaveRequest::where('user_id', Auth::user()->id)
    			->with('leaveType')
                ->latest()
        		->paginate(10);
        return view('app.leave.employee_requests', compact('requests'));
    }

    public function create()
    {
    	//get leave taken by the user
    	$requests = Leave::leftJoin('requests',function ($join) {
	            $join->on('leaves.id', '=', 'requests.leave_type_id')
	                ->where('requests.user_id', Auth::user()->id)
					->where('requests.status', '!=', 'rejected')
					//->whereDate('requests.starting_date', '<=', \Carbon\Carbon::today())
					->whereYear('requests.starting_date', date('Y'))
                    ->whereNull('requests.deleted_at');
		        })
    			->select((DB::raw('ifnull(SUM(requests.days), 0) as days_count, leave_type, leaves.days, leaves.id')))
        		->groupBy('leave_type', 'leaves.days', 'leaves.id')->orderBy('leaves.id')->get();
        $weekend_off = LeaveRequest::usedWeekendOffCount();

        return view('app.leave.create', compact('requests', 'weekend_off'));
    }

    public function store(Request $request)
    {

        $newRequest = $request->validate([
            'leave_type_id'	=> 'required|integer',
            'starting_date' => 'required|date|after:today',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'reason' => 'string',
        ]);

        $noOfLeaves = \Carbon\Carbon::parse($request->starting_date)->diffInDays(\Carbon\Carbon::parse($request->ending_date)) +1;

        $newRequest['days'] = $noOfLeaves;
        //$newRequest['user_id'] = Auth::user()->id;

        if ($request->leave_type_id == 0) {
            //weekend off
            //get all weekend off this year
            /*$oldRequests = LeaveRequest::where('leave_type_id', 0)
                    ->where('user_id', Auth::user()->id)
                    ->where('status', '!=', 'rejected')
                    ->whereYear('starting_date', date('Y'))
                    ->whereNull('deleted_at')
                    ->sum('days');

            if( ($oldRequests > Auth::user()->details->weekend_off) || (($oldRequests+$noOfLeaves) > Auth::user()->details->weekend_off) ) {
                request()->session()->flash('warning', 'Remaining weekend offs is not sufficent');
                return redirect()->back();
            }*/

        }
        else {

            $oldRequests = Leave::leftJoin('requests',function ($join) {
	            $join->on('leaves.id', '=', 'requests.leave_type_id')
	                ->where('requests.user_id', Auth::user()->id)
					->where('requests.status', '!=', 'rejected')
					//->whereDate('requests.starting_date', '<=', \Carbon\Carbon::today())
					->whereYear('requests.starting_date', date('Y'))
                    ->whereNull('requests.deleted_at');
		        })
        		->where('leaves.id', $request->leave_type_id)
    			->select((DB::raw('ifnull(SUM(requests.days), 0) as days_count, leave_type, leaves.days, leaves.id')))
        		->groupBy('leave_type', 'leaves.days', 'leaves.id')->orderBy('leaves.id')->get()->first();

            //check necessary leaves available

    		if( ($oldRequests->days_count > $oldRequests->days) || (($oldRequests->days_count+$noOfLeaves) > $oldRequests->days) ) {
    			request()->session()->flash('warning', 'Remaining ' . $oldRequests->leave_type . ' is not sufficent');
    			return redirect()->back();
    		}

            //paid leaves only applicable to those who complete atleast two years of service

    		if($oldRequests->leave_type == 'Paid leave') {
    			$joiningDate = \App\UserDetails::where('user_id', Auth::user()->id)
    					->first('joining_date');

    			if(!(\Carbon\Carbon::parse($joiningDate->joining_date)->diffInDays(\Carbon\Carbon::parse($request->starting_date)) > 730)) {
    				request()->session()->flash('warning', 'Paid leave is only applicable to those who complete atleast two years of service.');
    				return redirect()->back();
    			}
    		}
        }

        //create request

        $LeaveRequest = LeaveRequest::create($newRequest);

            request()->session()->flash('success', 'Leave is requested.');

        return redirect()->route('requests.index');
    }


    public function destroy(Request $postRequest, LeaveRequest $request)
    {

        $postRequest->validate(['request_id' => 'required']);

        if ($postRequest->get('request_id') == $request->id) {
            if ($request->delete()) {
                return redirect()->back();
            }
        }
        return back();
    }
}
