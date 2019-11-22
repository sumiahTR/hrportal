<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Request as LeaveRequest;
use Auth;
use DB;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$requests = LeaveRequest::latest()
    			->with('user')
        		->paginate(10);
        return view('app.leave.requests', compact('requests'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'leaveStatus' => 'required',
        ]);

        $result = LeaveRequest::where('id', $request->id)
                ->update([ 'status' => $request->leaveStatus ]);

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
        return view('app.leave.show', compact('request', 'totalRequests'));
    }

    public function update(Request $request, $leaveRequest)
    {
        $data = $request->validate([
            'remarks' => 'nullable',
            'status' => 'required',
        ]);

        $result = LeaveRequest::where('id', $leaveRequest)
                ->update($data);

        return redirect('/requests');
    }



}
