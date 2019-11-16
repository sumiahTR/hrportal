@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Leaves</h1>
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
    <form method="POST" action="{{ url('leaves/update/') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      @foreach($leaves as $leave)
      @if(isset($leave->leave_type))
      <div class="form-group">
        <label for="title">{{$leave->leave_type}}</label>
        <input type="number" min="0" class="form-control" id="{{$leave->id}}"  name="days[{{$leave->id}}]" value="@if(null !==(old('days'))){{old('days')}}@else{{$leave->days}}@endif" required="">

      </div>
      @endif

      

      @endforeach
      

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection