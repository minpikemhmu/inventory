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
          <h3 class="tile-title d-inline-block">Incomes List ({{$mytime->toFormattedDateString()}})</h3>
          <a href="{{route('incomes.create')}}" class="btn btn-primary float-right">Add Income</a>
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item Code</th>
                  <th>Delivery Men</th>
                  <th>Payment type</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; $total=0 @endphp
                @foreach($incomes as $row)
                @php $total+=$row->amount; @endphp
                <tr>
                  <td>{{$i++}}</td>
                  <td><span class="badge badge-primary">{{$row->way->item->codeno}}</span></td>
                  <td>{{$row->way->delivery_man->user->name}}</td>
                  <td>{{$row->payment_type->name}}</td>
                  <td>{{number_format($row->amount)}}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="4">Total amount</td>
                  <td>{{number_format($total)}}</td>
                </tr>
                
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 