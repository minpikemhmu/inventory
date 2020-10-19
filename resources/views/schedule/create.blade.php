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
          <h3 class="tile-title d-inline-block">Create Schedule Form</h3>
          
          <form method="" action="">
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

            <div class="form-group">
              <label for="InputDate">Date:</label>
              <input class="form-control" id="InputDate" type="date">
            </div>

            <div class="form-group">
              <label for="InputRemark">Remark:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark"></textarea>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 