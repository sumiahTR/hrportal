<?php

namespace App\Http\Controllers;

use App\Leave;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$leaves = Leave::all();
        return view('app.leave.list', compact('leaves'));
    }

    public function update(Request $request)
    {
        $leaveData = $request->validate([
            'days.*' => 'required',
        ]);

        foreach ($leaveData['days'] as $key => $value) {
            Leave::where('id', $key)
                ->update([ 'days' => $value ]);
        }
        

        request()->session()->flash('success', 'Leave updated.');

        return redirect()->back();
    }
}
