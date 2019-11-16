@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Add Holiday</h1>
  </div>
  <hr>

  <div class="col-md-6">
    <form method="POST" action="{{ url('holidays/store') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title" name="title" required="">
        @error('title')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="date">Holiday Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Holiday Date" name="date" required="">
        @error('date')
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