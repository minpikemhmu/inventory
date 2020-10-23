@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Ways</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('ways')}}">Ways</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">Ways List ({{$mytime->toFormattedDateString()}})</h3>

          <div class="float-right actions">
            <a href="#" class="btn btn-success btn-sm mx-2 success">Success</a>
            <a href="#" class="btn btn-warning btn-sm mx-2 return">Return</a>
            <a href="#" class="btn btn-danger btn-sm mx-2 reject">Reject</a>
          </div>

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
                @foreach($ways as $way)
                <tr>
                  <td>
                    <div class="animated-checkbox">
                      <label class="mb-0">
                        <input type="checkbox" name="ways[]" value="{{$way->id}}"><span class="label-text"> </span>
                      </label>
                    </div>
                  </td>
                  <td>
                    {{$way->item->codeno}}
                    @if($way->status_code == '001')
                      <span class="badge badge-info">{{'success'}}</span>
                    @elseif($way->status_code == '002')
                      <span class="badge badge-warning">{{'return'}}</span>
                    @endif

                  </td>
                  <td class="text-danger">{{$way->item->township->name}}</td>
                  <td>
                    {{$way->item->receiver_name}} <span class="badge badge-dark">{{$way->item->receiver_phone_no}}</span>
                  </td>
                  <td class="text-danger">{{$way->item->expired_date}}</td>
                  <td>{{$way->item->amount}}</td>
                  <td>
                    <a href="#" class="btn btn-primary detail" data-id="{{$way->item->id}}">Detail</a>
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

  {{-- Item Detail modal --}}
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
    $(document).ready(function () {
      // $('.delivery_actions').hide();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

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

      // control actions
      var $actions = $(".actions").hide();
      $cbs = $('input[name="ways[]"]').click(function() {
          $actions.toggle( $cbs.is(":checked") , 2000);
      });

      $('.success').click(function (e) {
        e.preventDefault();
        var ways = [];
        $.each($("input[name='ways[]']:checked"), function(){
          let wayObj = {id:$(this).val()};
          ways.push(wayObj);
        });
        $.post("{{route('makeDeliver')}}",{ways:ways},function (response) {
          console.log(response);
          alert('successfully changed!')
        })
      })

    })
  </script>
@endsection