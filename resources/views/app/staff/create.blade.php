@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Add Employee</h1>
  </div>
  <hr>

  <div class="col-md-6">
    <form method="POST" action="{{ route('staffs.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="title">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" name="name" required="" value="{{old('name')}}">
        @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" required="" value="{{old('email')}}">
        @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="employee_no">Emplyee Number</label>
        <input type="text" class="form-control @error('employee_no') is-invalid @enderror" id="employee_no" placeholder="Emplyee Number" name="employee_no" required="" value="{{old('employee_no')}}">
        @error('employee_no')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="mobile">Mobile Number</label>
        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="Mobile Number" name="mobile" value="{{old('mobile')}}">
        @error('mobile')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="joining_date">Joining Date</label>
        <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" placeholder="Joining Date" name="joining_date" required="">
        @error('joining_date')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="dob">DOB</label>
        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" placeholder="Date of birth" name="dob" required="">
        @error('dob')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="designation">Designation</label>
        <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" placeholder="Designation" name="designation" required="" value="{{old('designation')}}">
        @error('designation')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="bank">Bank</label>
        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank" placeholder="Bank" name="bank" required="" value="{{old('bank')}}">
        @error('bank')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="account_no">Bank Account Number</label>
        <input type="text" class="form-control @error('account_no') is-invalid @enderror" id="account_no" placeholder="Account Number" name="account_no" required="" value="{{old('account_no')}}">
        @error('account_no')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="pan">PAN</label>
        <input type="text" class="form-control @error('pan') is-invalid @enderror" id="pan" placeholder="PAN Number" name="pan" value="{{old('pan')}}">
        @error('pan')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</div>
@endsection