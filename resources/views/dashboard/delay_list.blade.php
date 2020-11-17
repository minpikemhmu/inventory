@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
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
          <h3 class="tile-title d-inline-block">Delay List ({{$mytime->toFormattedDateString()}})</h3>
          <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Codeno</th>
                        <th>Township</th>
                        <th>Receiver Info</th>
                        <th>Expired Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         @php $i=1; @endphp
                        @foreach($delayitems as $row)
                        

                        @php
                       $today=strtotime($mytime->toDateString());
                        $expdate=strtotime($row->created_at->toDateString());
                        $difference=$today-$expdate;
                        $differentday=round($difference / 86400);

                       @endphp
                        <td>{{$i++}}</td>
                        <td>@if($differentday==1)<span class="badge badge-warning">{{$row->codeno}}</span> @elseif($differentday>1)<span class="badge badge-danger">{{$row->codeno}}</span>@endif</td>
                        <td class="text-danger">{{$row->township->name}}</td>
                        <td>
                          {{$row->receiver_name}} <span class="badge badge-dark">{{$row->receiver_phone_no}}</span>
                        </td>
                        <td>{{$row->expired_date}}</td>
                        <td>{{number_format($row->amount)}}</td>
                        <td>
                          <a href="#" class="btn btn-primary detail" data-id="{{$row->id}}">Detail</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
        </div>
      </div>
    </div>
  </main>


  <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Receiver Name:</strong> <span id="rname">Ma Mon</span></p>
          <p ><strong >Receiver Phone No:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >Receiver Address:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>
          <p><strong>Remark:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
       $('.detail').click(function () {
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.post('itemdetail',{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);
          $(".rcode").html(res.codeno);
        })
      })

  })
</script>

@endsection