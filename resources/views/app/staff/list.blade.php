@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h3">Employees</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

          <a href="{{ route('staffs.create') }}" class="btn btn-sm btn-outline-success"><span data-feather="plus"></span>Add</a>
        </div>
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
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Designation</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($staffs as $key => $staff)
            <tr>
              <td>{{ $staffs->firstItem() + $key }}</td>
              <td>{{$staff->name}}</td>
              <td>{{$staff->email}}</td>
              {{--<td>{{date('d M Y h:i a', strtotime($staff->created_at))}}</td>--}}
              <td>{{$staff->details->designation}}</td>
              <td>
                @if($staff->is_active==1)
                <p class="text-success">Active</p>
                  <!--<div class="badge badge-success text-wrap p-2 m-1" style="width: 4rem;">Active</div>-->
                @else
                  <p class="text-danger">Inactive</p>
                @endif
              </td>
              <td>
              	@if($staff->is_active==1)
                  <a href="/staffs/disable/{{$staff->id}}" class="btn btn-outline-danger btn-sm m-1">
                    <i class="fa fa-pencil"></i> 
                    Disable 
                  </a>
                @else
                  <a href="/staffs/enable/{{$staff->id}}" class="btn btn-outline-success btn-sm m-1">
                    <i class="fa fa-pencil"></i> 
                    Enable 
                  </a>
                @endif

                  <a href="{{ route('staffs.show', $staff) }}" class="btn btn-outline-primary btn-sm m-1">
                    <i class="fa fa-pencil"></i> 
                    View 
                  </a>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $staffs->links() }}
      </div>
    </div>
@endsection