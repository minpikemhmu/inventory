@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        @php $mytime = Carbon\Carbon::now(); @endphp
        <h1><i class="fa fa-dashboard"></i> {{ __("Success Ways")}} ({{$mytime->toFormattedDateString()}})</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('success_ways')}}">{{ __("Success Ways")}}</a></li>
      </ul>
    </div>

    <div  class="row my-4 ">
      <div class="col-md-4">
        <label for="startdate">Start Date</label>
        <input type="date" name="start_date" class="form-control startdate" id="start_date">
      </div>
      <div class="col-md-4">
        <label for="enddate">End date</label>
        <input type="date" name="end_date" class="form-control end_date" id="enddate">
      </div>

      <div class="col-md-4 mt-4">
        <button class="btn btn-info btn_search">Search</button>
      </div>
    </div>

    <div class="row mysuccessrow">
      @foreach($success_ways as $row)
      <div class="col-md-4">
        <div class="card mb-3">
          <h5 class="card-header">{{$row->item->receiver_name}}
            @if($row->status_code == '001')
            <span class="badge badge-info">{{'success'}}</span>
            @elseif($row->status_code == '002')
            <span class="badge badge-warning">{{'return'}}</span>
            @elseif($row->status_code == '003')
            <span class="badge badge-danger">{{'reject'}}</span>
            @endif
            {{-- <small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{$row->item->expired_date}}</small> --}}
          </h5>
          <div class="card-body">
            <h5 class="card-title">{{ __("Item Code")}}: {{$row->item->codeno}}</h5>
            <h5 class="card-title">{{ __("Delivered Address")}}: 
              @if($row->item->sender_gate_id != null)
                {{$row->item->SenderGate->name}}
              @elseif($row->item->sender_postoffice_id != null)
                {{$row->item->SenderPostoffice->name}}
              @else
                {{$row->item->township->name}}
              @endif
            </h5>
          <p class="card-text">{{ __("Full Address")}}:{{$row->item->receiver_address}}</p>
          <p class="card-text">
            {{ __("Receiver Phone No")}}:{{$row->item->receiver_phone_no}}
          </p>
          <p class="card-text">
           Client {{ __("Name")}}: {{$row->item->pickup->schedule->client->user->name}}
          </p>
          <p class="card-text">
           Client {{ __("Phone No")}}: {{$row->item->pickup->schedule->client->phone_no}}
          </p>
            <p class="card-text">Amount: {{number_format($row->item->amount)}} Ks</p>
            @if($row->income==null)
            <a href="{{route('normal',$row->id)}}" class="btn btn-warning">{{ __("Edit")}}</a>
            @endif
            <a href="#" class="btn btn-primary detail" data-id="{{$row->item->id}}">{{ __("Detail")}}</a> 
          </div>
        </div>
      </div>
      @endforeach
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
          <p><strong>{{ __("Receiver Name")}}:</strong> <span id="rname">Ma Mon</span></p>
          <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address")}}:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>
          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  {{-- return modal --}}
  <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel">Return</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="wayid" id="returnway" value="">
          </div>
          <div class="form-group">
            <label for="InputDate">Date:</label>
            <input type="date" name="return_date" class="form-control returndate" id="InputDate">
          </div>
          <div class="form-group">
            <label for="InputRemark">Remark:</label>
            <textarea class="form-control returnremark" id="InputRemark" name="remark"></textarea>
            <span class="Eremark error d-block" ></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btnreturn">OK</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- reject modal --}}
  <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel">Reject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="wayid" id="rejectway" value="">
            </div>
          <div class="form-group">
                  <label for="InputRemark">Remark:</label>
                  <textarea class="form-control rejectremark" id="InputRemark" name="remark"></textarea>
                  <span class="Ejremark error d-block" ></span>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btnreject">OK</button>
          </form>
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

      $('.mysuccessrow').on('click','.detail',function () {
        var id=$(this).data('id');
        console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.post("{{route('itemdetail')}}",{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);
          $(".rcode").html(res.codeno);

          })
      })


        $('.detail').click(function () {
        var id=$(this).data('id');
        console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.post("{{route('itemdetail')}}",{id:id},function(res){
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
        var wayid = $(this).data('id');
        e.preventDefault();
        var ways = [];
        if (!wayid) {
          $.each($("input[name='ways[]']:checked"), function(){
            let wayObj = {id:$(this).val()};
            ways.push(wayObj);
          });
        }else{
          let wayObj = {id:wayid};
          ways.push(wayObj);
        }
        $.post("{{route('makeDeliver')}}",{ways:ways},function (response) {
          console.log(response);
          alert('successfully changed!')
          location.href="{{route('success_ways')}}";
        })
      })

      $('.return').click(function (e) {
        e.preventDefault();
        $('#returnModal').modal('show');
        var id=$(this).data('id');
        $("#returnway").val(id);
      })

      $(".btnreturn").click(function(){
        var wayid=$("#returnway").val();
        var remark= $(".returnremark").val();
        var date= $(".returndate").val();
        var url="{{route('retuenDeliver')}}";
         $.ajax({
          url:url,
          type:"post",
          data:{wayid:wayid,remark:remark,date:date},
          dataType:'json',
          success:function(response){
            if(response.success){
               $('#returnModal').modal('hide');
               $('.Eremark').text('');
              $('span.error').removeClass('text-danger');
              $('.success').removeClass('d-none');
              $('.success').show();
              $('.success').text('successfully added to return list');
              $('.success').fadeOut(3000);
              location.href="{{route('pending_ways')}}";
            }
          },
          error:function(error){
            var message=error.responseJSON.message;
            var errors=error.responseJSON.errors;
            console.log(error.responseJSON.errors);
            if(errors){
              var remark=errors.remark;
              $('.Eremark').text(remark);
              $('span.error').addClass('text-danger');
            }

          }
          

        })
      })



       $('.reject').click(function (e) {
        e.preventDefault();
        $('#rejectModal').modal('show');
        var id=$(this).data('id');
        $("#rejectway").val(id);
      })

        $(".btnreject").click(function(){
        var wayid=$("#rejectway").val();
        var remark= $(".rejectremark").val();
        var url="{{route('rejectDeliver')}}";
         $.ajax({
          url:url,
          type:"post",
          data:{wayid:wayid,remark:remark},
          dataType:'json',
          success:function(response){
            if(response.success){
               $('#rejectModal').modal('hide');
               $('.Ejremark').text('');
              $('span.error').removeClass('text-danger');
              $('.success').removeClass('d-none');
              $('.success').show();
              $('.success').text('successfully added to reject list');
              $('.success').fadeOut(3000);
              location.href="{{route('pending_ways')}}";
            }
          },
          error:function(error){
            var message=error.responseJSON.message;
            var errors=error.responseJSON.errors;
            console.log(error.responseJSON.errors);
            if(errors){
              var remark=errors.remark;
              $('.Ejremark').text(remark);
              $('span.error').addClass('text-danger');
            }

          }
          

        })
      })


        // search date

        $('.btn_search').click(function(){
          var start_date = $('.start_date').val();
          var end_date = $('.end_date').val();
          html = '';
          $.post('success_deli_date',{start_date:start_date,end_date:end_date},function(res){
            if(res){
              $.each(res,function(i,v){
              html+=`<div class="col-md-4">
                      <div class="card mb-3">
                        <h5 class="card-header">${v.item.receiver_name}`
                          if(v.status_code=='001'){
                          html+=`<span class="badge badge-info">success</span>`}
                          else if(v.status_code == '002'){
                          html+=`<span class="badge badge-warning">return</span>`}
                          else if(v.status_code == '003'){
                         html+=`<span class="badge badge-danger">reject</span>`}
                         html+= `<small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ${v.item.expired_date}</small></h5>`
                          html+=`<div class="card-body">
                          <h5 class="card-title">Item Code: ${v.item.codeno}}</h5>
                        <h5 class="card-title">Delivered Address: `
                            if(v.item.sender_gate_id!=null){
                            html+=`${v.item.sender_gate.name}`}
                            else if(v.item.sender_postoffice_id != null){
                             html+=`${v.item.sender_postoffice.name}`
                            }
                            else{
                            html+=`${v.item.township.name}`}
                         html+=`</h5>
                        <p class="card-text">Full Address:${v.item.receiver_address}</p>
                        <p class="card-text">
                          Receiver Phone No:${v.item.receiver_phone_no}
                        </p>
                        <p class="card-text">
                         Client Name: ${v.item.pickup.schedule.client.user.name}
                        </p>
                        <p class="card-text">
                         Client Phone No: ${v.item.pickup.schedule.client.phone_no}
                        </p>
                        <p class="card-text">`
                          if(v.item.paystatus==1){
                           html+= `Amount: ${v.item.amount}Ks`
                         }
                           {{-- <span class="badge badge-success">ma shin ya thay</span> --}}
                          else
                          {
                          html+=`<span class="badge badge-success">All Paid!</span>`
                        }
                          
                        html+=`</p>`
                        
                          
                          if(v.status_code=="005"){
                         html+=`<a href="#" class="btn btn-info btn-sm success" data-id="${v.id}">Success</a>
                          <a href="#" class="btn btn-warning btn-sm return" data-id="${v.id}">Return</a>
                          <a href="#" class="btn btn-danger btn-sm reject" data-id="${v.id}">Reject</a>`
                        }
                        html+=`
                        <a href="{{route('normal',":id")}}" class="btn btn-sm btn-warning edit" data-id="${v.item.id}">Edit</a>
                        <a href="#" class="btn btn-sm btn-primary detail" data-id="${v.item.id}">Detail</a> 
                        </div>
                      </div>
                    </div>`;
                    html = html.replace(':id',v.id);
                  })

                $(".mysuccessrow").html(html)

                    }

            })
          })

    })
  </script>
@endsection