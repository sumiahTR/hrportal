<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\Request as LeaveRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $staffs = User::where('id', '!=', Auth::user()->id)
                ->where('role', 'employee')
                ->count();
        $requests = LeaveRequest::count();
        $absentees = LeaveRequest::where('status', 'approved')
                ->whereDate('starting_date', '<=', \Carbon\Carbon::today())
                ->whereDate('ending_date', '>=', \Carbon\Carbon::today())
                ->groupBy('user_id')
                ->count();
        $holidays = Holiday::count();
        return view('home', compact('staffs', 'requests', 'absentees', 'holidays'));
    }
}
