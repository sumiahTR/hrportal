@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h3">Shift</h1>

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
      @can('isEmployee')
        <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRmK2PkLZXAiD8foO0MGs8gLmie5TYMgQR4iNOUxvt_27dDpjGrZ6NvJFu6GgNkxhsdWcTtjFgYlPFH/pubhtml?widget=true&amp;headers=True&amp;chrome=True" height="400px"></iframe>
        @endcan
        @can('isAdmin')
        <iframe src="https://docs.google.com/spreadsheets/d/1ZfbsHMf0KI5LiubyMwRe46PogJXqGcew045w-F2E8h8/edit#gid=0" height="450px"></iframe>
        @endcan

    </div>
@endsection