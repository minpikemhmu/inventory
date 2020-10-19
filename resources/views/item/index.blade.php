@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">Items</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item List</h3>
          <a href="{{route('items.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Codeno</th>
                <th>Client Name</th>
                <th>Expired Date</th>
                <th>Amount</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>001-0003</td>
                <td>Ma San</td>
                <td>25-10-2020</td>
                <td>7000</td>
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
  </main>
@endsection 