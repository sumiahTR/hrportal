@extends('layouts.dashboard')

@section('content')
<div class="row pb-2">
  @foreach($requests as $request)
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">{{$request->leave_type}}</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{$request->days - $request->days_count}} of {{$request->days}}</h3>
                <i data-feather="calendar" class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-danger">remaining <span class="text-black ml-1"><small></small></span></p>
            </div>
          </div>
        </div>
    @endforeach
  </div>
        
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Request Leave</h1>
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
    <form method="POST" action="{{ route('requests.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="leave_type_id">Leave Type</label>
        <select class=" custom-select" name="leave_type_id">
          @foreach($requests as $request)
          <option value="{{$request->id}}">{{$request->leave_type}}</option>
          @endforeach
        </select>

        @error('ending_date')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>


      <div class="form-group">
        <label for="starting_date">From</label>
        <input type="date" class="form-control @error('starting_date') is-invalid @enderror" id="starting_date" placeholder="Starting Date" name="starting_date" required="">
        @error('starting_date')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="ending_date">To</label>
        <input type="date" class="form-control @error('ending_date') is-invalid @enderror" id="ending_date" placeholder="Ending Date" name="ending_date" required="">
        @error('ending_date')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="reason">Reason</label>
        <textarea name="reason" required="" class="form-control">
        </textarea>
      </div>
      

      <button type="submit" class="btn btn-primary">Request</button>
    </form>
  </div>
</div>
@endsection