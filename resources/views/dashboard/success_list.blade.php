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

          <div class="row">
            <div class="form-group col-md-4">
              {{-- <label for="InputMonth">Select Month:</label> --}}
              <select class="form-control" name="month" id="InputMonth">
                <optgroup label="Select Month">
                  <option value="01">Jan</option>
                  <option value="02">Feb</option>
                  <option value="03">Mar</option>
                  <option value="04">Apr</option>
                  <option value="05">May</option>
                  <option value="06">Jun</option>
                  <option value="07">July</option>
                  <option value="08">Aug</option>
                  <option value="09">Sep</option>
                  <option value="10">Oct</option>
                  <option value="11">Nov</option>
                  <option value="12">Dec</option>
                </optgroup>
              </select>
            </div>
            <div class="form-group col-md-4">
              {{-- <label for="InputDeliveryMan">Select Delivery Man:</label> --}}
              <select class="form-control" id="InputDeliveryMan" name="deliveryman">
                <optgroup label="Select Delivery Man">
                  @foreach($delivery_men as $deliveryman)
                    <option value="{{$deliveryman->id}}" data-name="{{$deliveryman->user->name}}">{{$deliveryman->user->name}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
            <div class="form-group col-md-4">
              <button class="btn btn-success search">Search</button>
            </div>
          </div>

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
                @php $i=1; @endphp
                @foreach($success_ways as $way)
                <tr>
                  <td>{{$i++}}</td>
                  <td><span class="badge badge-primary">{{$way->item->codeno}}</span></td>
                  <td>{{$way->delivery_man->user->name}}</td>
                  <td>{{number_format($way->item->amount)}} Ks</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
        </div>
      </div>
    </div>
  </main>
@endsection 