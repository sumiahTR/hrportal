<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Request as LeaveRequest;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = (new LeaveRequest)->newQuery();
        // Filter requests based on user id.
        if ($request->filled('user')) {
            $query->where('user_id', $request->input('user'));
        }
        // Filter requests based on leave type.
        if ($request->filled('type')) {
            $query->where('leave_type_id', $request->input('type'));
        }
        $requests = $query->latest()->with('user')
                ->with('updatedby')
                ->paginate(10);

        $staffs = User::where('id', '!=', Auth::user()->id)
                ->where('role', 'employee')
                ->select('id', 'name')
                ->get();
        $leaves = Leave::all();
        return view('app.leave.requests', compact('requests', 'staffs', 'leaves'));
    }

    public function updateStatus(Request $request)
    {
        
        $request->validate([
            'id' => 'required',
            'leaveStatus' => 'required',
        ]);

        if($request->leaveStatus =='rejected')
        {
            $num_of_daysapproved = 0;
            $days_approved = '';
        }
        else if($request->leaveStatus =='approved')
        {
            $current = LeaveRequest::where('id', $request->id)
                        ->select('days','starting_date','ending_date')
                        ->first();
            $num_of_daysapproved = $current->days;
            $starting_date = $current->starting_date;
            $ending_date = $current->ending_date;
            $days = '';
            $n = 0;
            
            for($i = $starting_date;$i <= $ending_date;$i++)
            {
                $n = ++$n;
                $days.=$i;
                if($n<$num_of_daysapproved)
                {
                    $days.=',';
                }
            }
            $days_approved =  $days;
        }
        else if($request->leaveStatus =='pending')
        {
            $num_of_daysapproved = '';
            $days_approved = '';
        }
        $result = LeaveRequest::where('id', $request->id)
                ->update([ 
                    'num_of_daysapproved' => $num_of_daysapproved,
                    'days_approved' => $days_approved,
                    'status' => $request->leaveStatus,
                    'updated_by' =>  Auth::user()->id
                ]);

        return $result;
    }

    public function view($leaveRequest)
    {
        $request = LeaveRequest::where('id', $leaveRequest)
                ->with('user')
                ->first();
        $totalRequests = Leave::leftJoin('requests',function ($join) use ($request) {
                $join->on('leaves.id', '=', 'requests.leave_type_id')
                    ->where('requests.user_id', $request->user->id)
                    ->where('requests.status', '!=', 'rejected')
                    ->whereYear('requests.starting_date', date('Y'))
                    ->whereNull('requests.deleted_at');
                })
                ->select((DB::raw('ifnull(SUM(requests.days), 0) as days_count, leave_type, leaves.days, leaves.id')))
                ->groupBy('leave_type', 'leaves.days', 'leaves.id')->orderBy('leaves.id')->get();
        $weekend_off = LeaveRequest::usedWeekendOffCount($request->user->id);
        $earn_leave = LeaveRequest::usedEarnLeaveCount($request->user->id);
        return view('app.leave.show', compact('request', 'totalRequests', 'weekend_off', 'earn_leave'));
    }

    public function update(Request $request, $leaveRequest)
    {

        $data = $request->validate([
            'remarks' => 'nullable',
            'status' => 'required',
        ]);

        $data['updated_by'] = Auth::user()->id;
        $approved_days = $request->leave_date;
        $countof_approve = count($approved_days);
        $data['num_of_daysapproved'] = $countof_approve;
        $days = '';
        $i = 0;
        foreach($approved_days as $a =>$s)
        {
            $i = ++$i;
            $days.=$s;
            if($i<$countof_approve)
            {
                $days.=',';
            }
        }
        $data['days_approved'] = $days;
        $result = LeaveRequest::where('id', $leaveRequest)
                ->update($data);

        //return redirect('/requests');
    }



}
