<?php

namespace App\Http\Controllers;

use App\Request as LeaveRequest;
use Auth;
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



}
