@extends('layouts.dashboard')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h2">Change Password</h1>
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
      <div class="col-md-6">
    <form method="POST" action="/users/change_password" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-5">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="password">Current Password</label>
        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" placeholder="Current password" name="old_password" required="">
        @error('old_password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required="">
        @error('password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"  placeholder="Confirm Password" name="password_confirmation" required="">
        @error('password_confirmation')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      
      <button type="submit" class="btn btn-primary"  name="password_change">Update</button>
    </form>
  </div>
@endsection