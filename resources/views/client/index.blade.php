@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Clients</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('clients.index')}}">Clients</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Client List</h3>
          <a href="{{route('clients.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Phone no</th>
                  <th>Address</th>
                  <th>Township</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Ma Su</td>
                  <td>09-98765432</td>
                  <td>Baho Street, Mayangone Township</td>
                  <td>Mayangone</td>
                  <td>
                    <a href="#" class="btn btn-primary">Detail</a>
                    <a href="#" class="btn btn-warning">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
  </main>
@endsection 