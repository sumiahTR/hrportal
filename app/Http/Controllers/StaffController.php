<?php

namespace App\Http\Controllers;

use App\Mail\SalaryCredited;
use App\SalarySlip;
use App\User;
use App\UserDetails;
use Auth;
use Hash;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
    	$staffs = User::where('id', '!=', Auth::user()->id)
        		->where('role', 'employee')
                ->where('name', 'like', '%'.request('q').'%')
        		->with('details')
        		->paginate(10);
        return view('app.staff.list', compact('staffs'));
    }

    public function enable(User $id)
    {
        $result = $id->update(['is_active' => 1]);

        if($result) {
            request()->session()->flash('success', 'Status successfully updated!');
        }
        else {
            request()->session()->flash('warning', 'Status Not updated!');
        }
        return redirect()->back();
    }

    public function disable(User $id)
    {
        $result = $id->update(['is_active' => 0]);

        if($result) {
            request()->session()->flash('success', 'Status successfully updated!');
        }
        else {
            request()->session()->flash('warning', 'Status Not updated!');
        }
        return redirect()->back();
    }

    public function create()
    {
        return view('app.staff.create');
    }

    public function store(Request $request)
    {

        $newUser = $request->validate([
            'name'	=> 'required|max:255',
            'email'	=> 'required|string|email|max:255|unique:users',
        ]);

        //set random password
		$newUser['password'] = bcrypt(str_random(10));

        $userDetails = $request->validate([
            'designation' => 'required|max:255',
            'employee_no' => 'nullable',
            'joining_date' => 'required|max:255',
            'dob' => 'required|max:255',
            'bank' => 'required|max:255',
            'account_no' => 'required|max:255',
            'pan' => 'max:255',
        ]);

        $user = User::create($newUser);
        $userDetails['user_id'] = $user->id;
        $details = UserDetails::create($userDetails);

        $token = Password::getRepository()->create($user);
        //send password reset email
		$user->sendPasswordResetNotification($token);

		if($user->id) {
            request()->session()->flash('success', 'Staff successfully created and Mail is sent to registered mail Id.');
        }

        return redirect()->route('staffs.index');
    }


    public function show(User $staff)
    {
        return view('app.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        return view('app.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $userData = $request->validate([
            'name'	=> 'required|max:255',
            'email'	=> 'required|string|email|max:255|unique:users,email,'.$staff->id,
        ]);

        $userDetails = $request->validate([
            'designation' => 'required|max:255',
            'employee_no' => 'nullable',
            'joining_date' => 'required|max:255',
            'dob' => 'required|max:255',
            'bank' => 'required|max:255',
            'account_no' => 'required|max:255',
            'pan' => 'max:255',
        ]);

        $staff->update($userData);
        $staff->details->update($userDetails);

        return redirect()->route('staffs.show', $staff);
    }

    public function destroy(Request $request, User $staff)
    {

        $request->validate(['user_id' => 'required']);

        if ($request->get('user_id') == $staff->id) {
            if ($staff->delete() && $staff->details->delete()) {
                return redirect()->route('staffs.index');
            }
        }

        return back();
    }

    public function change_password()
    {
    	return view('app.staff.form');
    }

    public function update_password(Request $request)
    {
    	if ($request->has('password_change')) {
		    $validatedData = $request->validate([
		        'old_password' => 'required',
            	'password' => 'required|string|min:6|confirmed',
		    ]);
		    if ((Hash::check($request->get('old_password'), Auth::user()->password))) {

		    	$user = User::find(Auth::user()->id);
				$user->password = bcrypt($request->password);
				$id = $user->save();

		    	if ($id) {
			    	return back()->with('success', 'Password changed successfully');
			    }
			    else {
			    	return back()->with('warning', 'Error. Please try again later.');
			    }
		    }
		    else{
		    	return back()->with('message', 'Current password doesnot match.');
		    }
		}
        return view('app.staff.form');
    }

    public function send_password_reset(User $user)
    {
       // $request['email'] = $user->email;
        $token = Password::getRepository()->create($user);
        //send password reset email
		$user->sendPasswordResetNotification($token);


		request()->session()->flash('success', 'Mail sent');

        return redirect()->back();
    }


    public function editSalaryDetails(User $staff)
    {
        /*dd($staff->details->salary_details);*/
        //$salary = \Config::get('settings.salary');
        //dd(json_encode($salary));
        //$salary = json_decode(json_encode($salary));
        /*echo $salary->income->basic->amount;
        dd((($salary)));*/

        return view('app.staff.salary', compact('staff'));
    }

    public function updateSalaryDetails(Request $request, User $staff)
    {
        $validatedData = $request->validate([
                'salary' => 'required',
            ]);
        $staff->details->update([
            'salary_details' => json_encode($request->salary),
        ]);
        request()->session()->flash('success', 'Salary details updated.
            ');
        return redirect()->route('staffs.show', $staff);
    }

    public function salarySlip(User $staff)
    {
        $incomeAmount = 0;
        $incomeArrear = 0;
        $deductionAmount = 0;
        $deductionArrear = 0;
        foreach ($staff->details->salary_details->income as $key => $value) {
            $incomeAmount += $value->amount;
            $incomeArrear += $value->arrear;

        }
        foreach ($staff->details->salary_details->deduction as $key => $value) {
            $deductionAmount += $value->amount;
            $deductionArrear += $value->arrear;

        }
        $data = [
            'staff' => $staff,
            'incomeArrear' =>$incomeArrear,
            'incomeAmount' => $incomeAmount,
            'deductionAmount' => $deductionAmount,
            'deductionArrear' =>$deductionArrear
        ];
        if(Input::get('send') == 'true') {
            $pdf = PDF::loadView('app.salary.'.$staff->details->salary_details->slip, $data);
            $filename = 'public/pdf/'.str_random(10).date('-d-m-Y').'.pdf';
            $result = Storage::put($filename, $pdf->output());
            $slip = SalarySlip::create([
                'user_id' => $staff->id,
                'slip' => $staff->details->salary_details->slip,
                'file_path' => $filename,
                'status' => 'slip generated'
            ]);

            Mail::to($staff)->send(new SalaryCredited($filename, $staff));
            $slip->status = 'mail sent';
            request()->session()->flash('success', 'Salary slip mail sent to staff.');
            return redirect()->back();
            
            /*request()->session()->flash('warning', 'Mail not sent. Try again.');
            return redirect()->back();*/

        }
        return view('app.salary.'.$staff->details->salary_details->slip, compact('staff', 'incomeAmount', 'incomeArrear', 'deductionAmount', 'deductionArrear'));
    }


}
