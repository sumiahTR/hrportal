@extends('layouts.dashboard')

@section('content')

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