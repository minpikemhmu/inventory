@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        @php $mytime = Carbon\Carbon::now(); @endphp
        <h1><i class="fa fa-dashboard"></i> Pickups ({{$mytime->toFormattedDateString()}})</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('pickups')}}">Pickups</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
         @if(session('successMsg') != NULL)
              <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
                  <strong> ✅ SUCCESS!</strong>
                  {{ session('successMsg') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif


        {{-- <div class="tile"> --}}
          
          {{-- <h3 class="tile-title d-inline-block">Pickup List ({{$mytime->toFormattedDateString()}})</h3> --}}
          
          {{-- <div class="table-responsive">
            <table class="table table-bordered dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>Township</th>
                  <th>Pickup Date</th>
                  <th>remark</th>
                  <th>Quantity</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1;@endphp
                @foreach($pickups as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td class="text-danger">{{$row->schedule->client->user->name}}</td>
                  <td>{{$row->schedule->client->address}}</td>
                  <td class="text-danger">{{$row->schedule->pickup_date}}</td>
                  <td>{{$row->schedule->remark}}</td>
                  <td>{{$row->schedule->quantity}}</td>
                  <td>
                    @if($row->status==0)
                    <a href="#" class="btn btn-primary">Pending</a>
                    <a href="{{route('pickupdone',$row->id)}}" class="btn btn-success">Done</a>
                    @else
                    <a href="#" class="btn btn-primary">completed pick up</a>
                    @endif
                    
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> --}}
          
          @foreach($pickups as $row)
          
          <div class="card mb-3">
            <h5 class="card-header">{{$row->schedule->client->user->name}} ({{$row->schedule->quantity}}) <small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{$row->schedule->pickup_date}}</small></h5>
            <div class="card-body">
              <h5 class="card-title">{{$row->schedule->client->address}}</h5>
              <p class="card-text">{{$row->schedule->remark}}</p>
            
              @if($row->status==0)
                <a href="#" class="btn btn-primary">Pending</a>
                <a href="{{route('pickupdone',$row->id)}}" class="btn btn-success">Done</a>
              @else
                <a href="#" class="btn btn-primary">completed pick up</a>
              @endif

            </div>
          </div>
          
          @endforeach
        {{-- </div> --}}
      </div>
    </div>
  </main>
@endsection 