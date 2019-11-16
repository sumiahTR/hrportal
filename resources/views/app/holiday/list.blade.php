@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h3">Holidays</h1>
        @can('isAdmin')
        <div class="btn-toolbar mb-2 mb-md-0">

          <a href="/holidays/create" class="btn btn-sm btn-outline-success"><span data-feather="plus"></span>Add</a>
        </div>
        @endcan
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
        <table class="table table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Holiday Date</th>
              <th>Day</th>
              @can('isAdmin')<th>Actions</th>@endcan
            </tr>
          </thead>
          <tbody>
            @foreach($holidays as $key => $holiday)
            <tr @if( $holiday->date <  Carbon\Carbon::today()) {{ "class=table-dark" }} @endif>
              <td>{{ $holidays->firstItem() + $key }}</td>
              <td>{{ $holiday->title }}</td>
              <td>{{date('d M Y', strtotime($holiday->date))}}</td>
              <td>{{date('l', strtotime($holiday->date))}}</td>
              @can('isAdmin')
                <td>
                  <a href="/holidays/edit/{{$holiday->id}}" class="btn btn-outline-primary btn-sm m-1">
                    <i class="fa fa-pencil"></i> 
                    Edit 
                  </a>

                  <form method="POST" action="{{ url('holidays/destroy/'.$holiday->id) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;Are you sure to delete this?&quot;)"  style="display: inline;">
                    {{ csrf_field() }} {{ method_field('delete') }}
                    <input name="holiday_id" type="hidden" value="{{ $holiday->id }}">
                    <button type="submit" class="btn btn-outline-danger btn-sm m-1"><span data-feather="trash-2"></span>Delete</button>
                </form>

                </td>
              @endcan
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $holidays->links() }}
      </div>
    </div>
@endsection