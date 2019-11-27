@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h3"></h1>

      </div>
      @if(Session::has('success')) 
        <div class="alert alert-success">
          <ul>
            <li>{{Session::get('success')}}</li>
          </ul>
        </div>
      @elseif(Session::has('warning')) 
        <div class="alert alert-danger">
          <ul>
            <li>{{Session::get('warning')}}</li>
          </ul>
        </div>
      @endif
      <div class="row pb-5">
        <div class="col-md-4">
          <div class="profile-img shadow" style="width: 250px; height: 180px; border: 1px solid grey;">
              <!--<img src="https://via.placeholder.com/275x183" alt=""/>-->
          </div>
        </div>
        <div class="col-md-6">
          <h5>
              {{$staff->name}}
          </h5>
          <h6 class="text-primary">
              {{$staff->details->designation}}
          </h6>
          <br>
          <hr>
          <div class="row">
              <div class="col-md-6">
                  <label>Employee No</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->employee_no}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Name</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->name}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Email</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->email}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Designation</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->designation}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Date of joining</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{date('d M Y', strtotime($staff->details->joining_date))}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Date of birth</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{date('d M Y', strtotime($staff->details->dob))}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Bank</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->bank}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Account Number</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->account_no}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>PAN Card</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->pan}}</p>
              </div>
          </div>
          @foreach($totalRequests as $remainingRequest)
            <div class="row">
                <div class="col-md-6">
                    <label>{{$remainingRequest->leave_type}}</label>
                </div>
                <div class="col-md-6 text-primary">
                    <p>{{$remainingRequest->days - $remainingRequest->days_count}} of {{$remainingRequest->days}} remaining</p>
                </div>
            </div>
          @endforeach
          <div class="row">
              <div class="col-md-6">
                  <label>Weekend Off</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->weekend_off - $weekend_off}} of {{$staff->details->weekend_off}} remaining</p>
              </div>
          </div>
          <hr>
          <div class="row">
              <div class="col-md-10 text-primary">
                  
                <a href="{{ route('staffs.edit', $staff) }}" class="btn btn-outline-success btn-sm m-1">
                  <span data-feather="edit"></span> Edit
                </a>
                <a href="{{ url('/staffs/salary/'. $staff->id) }}" class="btn btn-outline-success btn-sm m-1">
                  <span data-feather="edit"></span> Edit Salary Details
                </a>
                <a href="{{ url('/staffs/salary_slip/'. $staff->id) }}" class="btn btn-outline-secondary btn-sm m-1" target="_blank">
                  <span data-feather="file"></span> Salary Slip
                </a>
                <a href="{{ url('/staffs/salary_slip/'. $staff->id . '?send=true') }}" class="btn btn-outline-primary btn-sm m-1">
                  <span data-feather="mail"></span> Email Salary Slip
                </a>
                <a href="/staffs/sendmail/{{$staff->id}}" class="btn btn-outline-primary btn-sm m-1">
                  <span data-feather="mail"></span> Resend Welcome Email
                </a>
                <form method="POST" action="{{ route('staffs.destroy', $staff) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;Are you sure to delete this?&quot;)"  style="display: inline;">
                    {{ csrf_field() }} {{ method_field('delete') }}
                    <input name="user_id" type="hidden" value="{{ $staff->id }}">
                    <button type="submit" class="btn btn-outline-danger btn-sm m-1"><span data-feather="trash-2"></span>Delete</button>
                </form>
                  
              </div>
          </div>
        </div>
      </div>



      <div class="row pb-5">
        <div class="col-md-6">
          <p></p>
          <p></p>
        </div>
      </div>
    </div>
@endsection