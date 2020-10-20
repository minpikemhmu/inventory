@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Pickups</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('pickups')}}">Pickups</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Pickup List (14-Oct-2020)</h3>
          <div class="table-responsive">
            <table class="table table-bordered dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>Township</th>
                  <th>Pickup Date</th>
                  <th>Quantity</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Ma San</td>
                  <td>Mayangone</td>
                  <td>25-10-2020</td>
                  <td>5</td>
                  <td>
                    <a href="#" class="btn btn-primary">Pending</a>
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