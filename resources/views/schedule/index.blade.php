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
        <li class="breadcrumb-item"><a href="{{route('cities.index')}}">Schedules</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Schedules List</h3>
          <a href="{{route('schedules.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Pickup Date</th>
                <th>Remark</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Client One</td>
                <td>25-10-2020</td>
                <td>This is a remark by clients</td>
                <td>
                  <a href="#" class="btn btn-primary">Assign</a>
                  <a href="#" class="btn btn-warning">Edit</a>
                  <a href="#" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </main>
@endsection 