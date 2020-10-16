@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Reports</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Debt List (14-Oct-2020)</h3>

          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Item Code</th>
                <th>Delivery Men</th>
                <th>Amount</th>
                <th>Client</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><span class="badge badge-primary">0001-0024</span></td>
                <td>Kyaw Lwin</td>
                <td>5,000</td>
                <th>Ma Shwe</th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
@endsection 