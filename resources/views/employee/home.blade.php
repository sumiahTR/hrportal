@extends('layouts.dashboard')

@section('content')

    <div class="row">

        <div class="col-md-3 grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">Leave Requests</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{$requests}}</h3>
                <i data-feather="users" class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-success"><span class="text-black ml-1"><small>(Year)</small></span></p>
            </div>
          </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <p class="card-title text-md-center text-xl-left">Holidays</p>
              <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">{{$holidays}}</h3>
                <i data-feather="layers"  class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
              </div>  
              <p class="mb-0 mt-2 text-success"><span class="text-black ml-1"><small>(Year)</small></span></p>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    </div>



@endsection
