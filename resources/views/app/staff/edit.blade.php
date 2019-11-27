@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Edit Employee</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-danger"><span data-feather="arrow-left"></span>Back</a>
        </div>
  </div>
  <hr>

  <div class="col-md-6">
    <form method="POST" action="{{ route('staffs.update', $staff) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ method_field('PUT') }}
      {{ csrf_field() }}

      <div class="form-group">
        <label for="title">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" name="name" value="@if(null !==(old('name'))){{old('name')}}@else{{$staff->name}}@endif" required="">
        @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="@if(null !==(old('email'))){{old('email')}}@else{{$staff->email}}@endif" required="">
        <p>* changing email changes login username</p>
        @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="employee_no">Emplyee Number</label>
        <input type="text" class="form-control @error('employee_no') is-invalid @enderror" id="employee_no" placeholder="Emplyee Number" name="employee_no" value="@if(null !==(old('employee_no'))){{old('employee_no')}}@else{{$staff->details->employee_no}}@endif" required="">
        @error('employee_no')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="joining_date">Joining Date</label>
        <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" placeholder="Joining Date" name="joining_date" value="@if(null !==(old('joining_date'))){{old('joining_date')}}@else{{$staff->details->joining_date}}@endif" required="">
        @error('joining_date')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="dob">DOB</label>
        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" placeholder="Date of birth" name="dob" value="@if(null !==(old('dob'))){{old('dob')}}@else{{$staff->details->dob}}@endif" required="">
        @error('dob')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="designation">Designation</label>
        <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" placeholder="Designation" name="designation" required="" value="@if(null !==(old('designation'))){{old('designation')}}@else{{$staff->details->designation}}@endif">
        @error('designation')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="bank">Bank</label>
        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank" placeholder="Bank" name="bank" value="@if(null !==(old('bank'))){{old('bank')}}@else{{$staff->details->bank}}@endif" required="">
        @error('bank')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="account_no">Bank Account Number</label>
        <input type="text" class="form-control @error('account_no') is-invalid @enderror" id="account_no" placeholder="Account Number" name="account_no" value="@if(null !==(old('account_no'))){{old('account_no')}}@else{{$staff->details->account_no}}@endif" required="">
        @error('account_no')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="pan">PAN</label>
        <input type="text" class="form-control @error('pan') is-invalid @enderror" id="pan" placeholder="PAN Number" name="pan" value="@if(null !==(old('pan'))){{old('pan')}}@else{{$staff->details->pan}}@endif">
        @error('pan')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="weekend_off">Weekend Off</label>
        <input type="Number" class="form-control @error('weekend_off') is-invalid @enderror" id="weekend_off" placeholder="Weekend off" name="weekend_off" value="@if(null !==(old('weekend_off'))){{old('weekend_off')}}@else{{$staff->details->weekend_off}}@endif">
        @error('weekend_off')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection