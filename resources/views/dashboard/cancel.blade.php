@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Cancel</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('cancel.index')}}">Cancel</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Cancel List</h3>
          
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Township</th>
                  <th>Delivery Fees</th>
                  <th>Deposit Amount</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                 @foreach($ways as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->item->receiver_name}} <span class="badge badge-info">{{$row->item->receiver_phone_no}}</span></td>
                  <td>{{$row->item->township->name}}</td>
                  <td>{{number_format($row->item->delivery_fees)}}</td>
                  <td>{{number_format($row->item->deposit)}}</td>
                  <td>{{number_format($row->item->amount)}} Ks</td>
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
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    //alert("ok");
  })
</script>
@endsection