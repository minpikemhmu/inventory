@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Schedules By Clients</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">Schedules</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @role('client')
            <h3 class="tile-title d-inline-block">Create Schedule Form</h3>
            <form method="post" action="{{asset('schedules.store')}}">
          @endrole
          @role('staff')
            <h3 class="tile-title d-inline-block">Create Schedule and Assign</h3>
            <form method="post" action="{{asset('schedules.storeandassign')}}">
            <div class="form-group">
              <label for="InputClientName">Client Name:</label>
              <select class="form-control" name="client_name" id="InputClientName">
                <optgroup label="Choose Client:">
                  <option value="">Ma Su</option>
                  <option value="">Ko Thi</option>
                  <option value="">Ma Mon</option>
                </optgroup>
              </select>
            </div>
          @endrole          
            <div class="form-group">
              <label for="InputDate">Date:</label>
              <input class="form-control" id="InputDate" type="date">
            </div>

            <div class="form-group">
              <label for="InputRemark">Remark:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark"></textarea>
            </div>
            @role('staff')
            <div class="form-group">
              <label for="InputDeliveryMan">Delivery Man:</label>
              <select class="form-control" name="deliveryman" id="InputDeliveryMan">
                <optgroup label="Choose Delivery Man">
                  <option value="1">Mg Mg</option>
                  <option value="2">U Kyaw</option>
                </optgroup>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">Save And Assign</button>
            </div>
            @endrole

            @role('client')
            <div class="form-group">
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
            @endrole
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 