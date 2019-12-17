@extends('layouts.dashboard')

@section('content')

<div class="row pb-2">
  @foreach($totalRequests as $remainingRequest)
        <div class="col-md grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">{{$remainingRequest->leave_type}}</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{$remainingRequest->days - $remainingRequest->days_count}} of {{$remainingRequest->days}}</h3>
                <i data-feather="calendar" class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-danger">remaining <span class="text-black ml-1"><small></small></span></p>
            </div>
          </div>
        </div>
    @endforeach
    <div class="col-md grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">Weekend Off</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{$request->user->details->weekend_off - $weekend_off}} of {{$request->user->details->weekend_off}}</h3>
                <i data-feather="calendar" class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-danger">remaining <span class="text-black ml-1"><small></small></span></p>
            </div>
          </div>
        </div>
        <div class="col-md grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">Earn Leave</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{Auth::user()->details->earn_leave - $earn_leave}} of {{Auth::user()->details->earn_leave}}</h3>
                <i data-feather="calendar" class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-danger">remaining <span class="text-black ml-1"><small></small></span></p>
            </div>
          </div>
        </div>
  </div>

<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Leave Request </h1>
  </div>
  <hr>
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
  <div class="col-md-6">
  <div class="row">
      <div class="col-md-3">
          <label>Staff:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p>{{$request->user->name}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Starting Date:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p>{{date('d M Y ', strtotime($request->starting_date))}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Ending Date:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p>{{date('d M Y ', strtotime($request->ending_date))}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Days:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p>{{Carbon\Carbon::parse($request->starting_date)->diffInDays(Carbon\Carbon::parse($request->ending_date)) +1}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Leave Type:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p>{{$request->leaveType->leave_type}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Reason:</label>
      </div>
      <div class="col-md-8 text-primary">
          <p>{{$request->reason}}</p>
      </div>
  </div>
  <div class="row">
      <div class="col-md-3">
          <label>Status:</label>
      </div>
      <div class="col-md-3 text-primary">
          <p class="text-@if($request->status=='pending'){{'primary'}}@elseif($request->status=='approved'){{'success'}}@else{{'danger'}} @endif">{{$request->status}}</p>
      </div>
  </div>
</div>
<hr>
  <div class="col-md-6">
    <form method="POST" action="{{ url('/requests/update/'.$request->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}


      <div class="form-group">
        <label for="starting_date">Status</label>
        <select  class="custom-select" id=""  name="status" >
          <option value="pending" @if($request->status=='pending'){{'selected'}} @endif>pending</option>
          <option value="approved" @if($request->status=='approved'){{'selected'}} @endif>approve</option>
          <option value="rejected" @if($request->status=='rejected'){{'selected'}} @endif>reject</option>
        </select>
      </div>


      <div class="form-group">
        <label for="remarks">Remarks</label>
        <textarea name="remarks" class="form-control">@if(null !==(old('remarks'))){{old('remarks')}}@else{{$request->remarks}}@endif
        </textarea>
      </div>
      

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection