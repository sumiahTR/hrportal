@extends('layouts.dashboard')

@section('css')
<style type="text/css">
#loading-overlay {
    position: absolute;
    width: 100%;
    height:100%;
    left: 0;
    top: 0;
    display: none;
    align-items: center;
    background-color: #000;
    z-index: 999;
    opacity: 0.5;
}
.loading-icon{ position:absolute;border-top:2px solid #fff;border-right:2px solid #fff;border-bottom:2px solid #fff;border-left:2px solid #767676;border-radius:25px;width:25px;height:25px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } } 
</style>
@endsection
@section('content')
<div class="card shadow p-4">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h3">Leave Requests</h1>
        @can('isEmployee')
        <div class="btn-toolbar mb-2 mb-md-0">

          <a href="{{ route('requests.create')}}" class="btn btn-sm btn-outline-success"><span data-feather="plus"></span>Request Leave</a>
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
        @can('isAdmin')
        <form class="form-inline" method="GET" action="" accept-charset="UTF-8">
          <select class="custom-select custom-select-sm mb-1 mr-sm-2" name="user">
            <option value="">select user</option>
            @foreach ($staffs as $staff)
            <option value="{{$staff->id}}" @if(request('user') == $staff->id) {{'selected'}} @endif >{{$staff->name}}</option>
            @endforeach
          </select>
          <select class="custom-select custom-select-sm mb-1 mr-sm-2" name="type">
            <option value="">select leave type</option>
            <option value="0" @if(!(is_null(request('type'))) && request('type') == 0) {{'selected'}} @endif>Weekend Off</option>
            @foreach ($leaves as $leave)
            <option value="{{$leave->id}}" @if(request('type') == $leave->id) {{'selected'}} @endif >{{$leave->leave_type}}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-sm btn-outline-success mb-1">Filter</button>
        </form>
        @endcan
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              @can('isAdmin')<th>Staff</th>@endcan
              <th>From</th>
              <th>To</th>
              <th>Days</th>
              <th>Leave Type</th>
              <th>Reason</th>
              <th>No:of Days Approved</th>
              <th>Dates Approved</th>
              <th>Remarks</th>
              <th>Status</th>
              <th>@can('isAdmin')Change Status @endcan @can('isEmployee') Actions @endcan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($requests as $key => $request)
            <?php
             $days = '';
              if($request->days_approved == '')
              { 
                $n = 0;
                $starting_date = $request->starting_date;
                $ending_date = $request->ending_date;
                for($i = $starting_date;$i <= $ending_date;$i++)
                {
                    $n = ++$n;
                    $days.=$i;
                    if($i != $ending_date)
                    {
                        $days.='<br>';
                    }
                }
              }
              else
              {
                $days = str_replace(',','<br>',$request->days_approved);
              }
            ?>
            <tr>
              <td>{{ $requests->firstItem() + $key }}</td>
              @can('isAdmin')<td>{{$request->user->name}}</td>@endcan
              <td>{{date('d M Y ', strtotime($request->starting_date))}}</td>
              <td>{{date('d M Y ', strtotime($request->ending_date))}}</td>
              <td>{{Carbon\Carbon::parse($request->starting_date)->diffInDays(Carbon\Carbon::parse($request->ending_date)) +1}}</td>
              <td>{{$request->leaveType->leave_type}}</td>
              @can('isAdmin')<td>{{substr($request->reason, 0, 25)}}@if(strlen($request->reason)>25){{'...'}}@endif</td>@endcan
              @can('isEmployee')<td>{{substr($request->reason, 0, 50)}}@if(strlen($request->reason)>25){{'...'}}@endif</td>@endcan
              <td>@if($request->num_of_daysapproved != '') {{$request->num_of_daysapproved}} @else {{$request->days}}@endif</td>
              <td>{!!$days!!}</td>
              <td>{{$request->remarks}}</td>
              <td>
                
                <p class="text-@if($request->status=='pending'){{'primary'}}@elseif($request->status=='approved'){{'success'}}@else{{'danger'}} @endif">{{$request->status}}</p>

              </td>
              <td>

                @can('isAdmin')
                  <form class="form-inline">
                  <select  class="custom-select" id="inlineFormCustomSelectPref"  name="leave_type_id" onchange="updateRequestStatus(this.value, {{ $request->id }})">
                    <option value="pending" @if($request->status=='pending'){{'selected'}} @endif>pending</option>
                    <option value="approved" @if($request->status=='approved'){{'selected'}} @endif>approve</option>
                    <option value="rejected" @if($request->status=='rejected'){{'selected'}} @endif>reject</option>
                  </select>
                  <a href="{{url('/requests/view/'.$request->id)}}" class="btn btn-outline-primary btn-sm m-1">View</a>
                </form>
                  
                @endcan
                @can('isEmployee')
                  @if( $request->starting_date >  Carbon\Carbon::today())
                    <form method="POST" action="{{ route('requests.destroy', $request) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;Are you sure to delete this?&quot;)"  style="display: inline;">
                      {{ csrf_field() }} {{ method_field('delete') }}
                      <input name="request_id" type="hidden" value="{{ $request->id }}">
                      <button type="submit" class="btn btn-outline-danger btn-sm m-1"><span data-feather="trash-2"></span>Delete</button>
                    </form>
                  @endif
                @endcan


              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $requests->appends(Request::except('page'))->render() }}
      </div>
    </div>
    <div id="loading-overlay">
      <div class="loading-icon"></div>
    </div> 
@endsection

<script type="text/javascript">
      function updateRequestStatus(leaveStatus, id) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          }
        });
        var token = $('input[name=_token]').val();
        $.ajax({
            url:"/requests/update",
            type: "post",
            data: {_token: token, id: id, leaveStatus: leaveStatus},
             beforeSend: function(){
            $("#loading-overlay").show();
        },
            success:function(result){
              $("#loading-overlay").hide();

              location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
              $("#loading-overlay").hide(); 
              alert("something went wrong");
            }
        });
       
      };

    </script>