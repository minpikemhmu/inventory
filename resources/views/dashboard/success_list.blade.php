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
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">Success List ({{$mytime->toFormattedDateString()}})</h3>
          <div class="table-responsive">

            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item Code</th>
                  <th>Delivery Men</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td><span class="badge badge-primary">0001-0024</span></td>
                  <td>Kyaw Lwin</td>
                  <td>3,000</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><span class="badge badge-primary">0001-0323</span></td>
                  <td>Min Pike</td>
                  <td>2,500</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td><span class="badge badge-primary">0031-0015</span></td>
                  <td>Kyaw Kyi</td>
                  <td>5,000</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td><span class="badge badge-primary">0031-0004</span></td>
                  <td>Hein Min</td>
                  <td>1,500</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 