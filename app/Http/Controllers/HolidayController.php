<?php

namespace App\Http\Controllers;

use App\Holiday;
use Auth;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$holidays = Holiday::oldest('date')
        		->paginate(10);
        return view('app.holiday.list', compact('holidays'));
    }


    public function create()
    {
        return view('app.holiday.create');
    }

    public function store(Request $request)
    {

        $newHoliday = $request->validate([
            'title'	=> 'required|max:255',
            'date'	=> 'required|date',
        ]);

        $holiday = Holiday::create($newHoliday);

		if($holiday) {
            request()->session()->flash('success', 'Holiday added.');
        }

        return redirect('/holidays');
    }


    public function edit(Holiday $holiday)
    {
        return view('app.holiday.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $holidayData = $request->validate([
            'title'	=> 'required|max:255',
            'date'	=> 'required|date',
        ]);

        $holiday->update($holidayData);

        request()->session()->flash('success', 'Holiday updated.');

        return redirect()->back();
    }

    public function destroy(Request $request, Holiday $holiday)
    {

        $request->validate(['holiday_id' => 'required']);

        if ($request->get('holiday_id') == $holiday->id) {
            if ( $holiday->delete() ) {
                return redirect()->back();
            }
        }

        return back();
    }

}
