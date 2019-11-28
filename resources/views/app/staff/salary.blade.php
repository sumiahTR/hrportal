@extends('layouts.dashboard')

@section('content')
<div class="card shadow p-4 mb-2">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 ">
    <h1 class="h4">Edit Salary details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-danger"><span data-feather="arrow-left"></span>Back</a>
        </div>
  </div>
  <hr>

  <div class="col-md-6">


          <div class="row">
              <div class="col-md-6">
                  <label>Employee No</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->employee_no}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Name</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->name}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Email</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->email}}</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <label>Designation</label>
              </div>
              <div class="col-md-6 text-primary">
                  <p>{{$staff->details->designation}}</p>
              </div>
          </div>
          <hr>

    <form method="POST" action="{{ url('/staffs/salary/'. $staff->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="pb-2">
      {{ csrf_field() }}

      <h5>Income Section</h5>
      <hr>

      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Slip</label>
        </div>
        <div class="col-7">
          <select name="salary[slip]" class="custom-select">
            <option value="tiding" @isset($staff->details->salary_details->slip) @if($staff->details->salary_details->slip == 'tiding') {{ 'selected' }} @endif @endisset>Tiding</option>
            <option value="metro" @isset($staff->details->salary_details->slip) @if($staff->details->salary_details->slip == 'metro') {{ 'selected' }} @endif @endisset>Metro</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Message</label>
        </div>
        <div class="col-7">
          <textarea name="salary[message]" class="form-control">@isset($staff->details->salary_details->message) {{$staff->details->salary_details->message}}@endif</textarea>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Salary Date (y-m-d)</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="date" name="salary[salary_date]" value="@isset($staff->details->salary_details->salary_date) {{$staff->details->salary_details->salary_date}}@endif">
        </div>
      </div>

      @isset($staff->details->salary_details->income)
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Basic</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[income][basic][amount]" value="{{$staff->details->salary_details->income->basic->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[income][basic][arrear]" value="{{$staff->details->salary_details->income->basic->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Dearness Allowance</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[income][dearness_allowance][amount]" value="{{$staff->details->salary_details->income->dearness_allowance->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[income][dearness_allowance][arrear]" value="{{$staff->details->salary_details->income->dearness_allowance->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Travelling Allowance</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[income][travelling_allowance][amount]" value="{{$staff->details->salary_details->income->travelling_allowance->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[income][travelling_allowance][arrear]" value="{{$staff->details->salary_details->income->travelling_allowance->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">HRA</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[income][hra][amount]" value="{{$staff->details->salary_details->income->hra->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[income][hra][arrear]" value="{{$staff->details->salary_details->income->hra->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Special Allowance</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[income][special_allowance][amount]" value="{{$staff->details->salary_details->income->special_allowance->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[income][special_allowance][arrear]" value="{{$staff->details->salary_details->income->special_allowance->arrear}}">
        </div>
      </div>
      @endisset

      <h5 class="pt-2">Deduction Section</h5>
      <hr>

      @isset($staff->details->salary_details->deduction)
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">EPF/EPSI</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[deduction][epf_epsi][amount]" value="{{$staff->details->salary_details->deduction->epf_epsi->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[deduction][epf_epsi][arrear]" value="{{$staff->details->salary_details->deduction->epf_epsi->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Medical Insurance</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[deduction][medical_insurance][amount]" value="{{$staff->details->salary_details->deduction->medical_insurance->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[deduction][medical_insurance][arrear]" value="{{$staff->details->salary_details->deduction->medical_insurance->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">Advance/Loan</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[deduction][advance_loan][amount]" value="{{$staff->details->salary_details->deduction->advance_loan->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[deduction][advance_loan][arrear]" value="{{$staff->details->salary_details->deduction->advance_loan->arrear}}">
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="inputEmail4">TDS</label>
        </div>
        <div class="col-7">
          <input type="text" class="form-control" placeholder="amount" name="salary[deduction][tds][amount]" value="{{$staff->details->salary_details->deduction->tds->amount}}">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="arrear" name="salary[deduction][tds][arrear]" value="{{$staff->details->salary_details->deduction->tds->arrear}}">
        </div>
      </div>
      @endisset

      

    <div class="form-group">
    </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection