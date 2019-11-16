@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Edit Holiday</h1>
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
    <form method="POST" action="{{ url('holidays/update/'.$holiday->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title" name="title" value="@if(null !==(old('title'))){{old('title')}}@else{{$holiday->title}}@endif" required="">
        @error('title')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="date">Holiday Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Holiday Date" name="date" value="@if(null !==(old('date'))){{old('date')}}@else{{$holiday->date}}@endif" required="">
        @error('date')
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