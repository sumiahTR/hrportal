<?php

namespace App\Http\Controllers\Employee;

use App\Holiday;
use App\Request as LeaveRequest;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	/*$staffs = User::where('id', '!=', Auth::user()->id)
                ->where('role', 'employee')
                ->count();*/
        $requests = LeaveRequest::where('user_id', Auth::user()->id)
    			->whereYear('starting_date', date('Y'))
    			->count();
        $holidays = Holiday::whereYear('date', date('Y'))->count();
        return view('employee.home', compact('requests', 'holidays'));
    }
}
