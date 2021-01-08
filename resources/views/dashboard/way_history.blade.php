@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Debt History")}}</h1>
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
          

         
         <div class="row">
              <div class="form-group col-md-3">
              <label for="InputStartDate">{{ __("Start Date")}}:</label>
              <input type="date" class="form-control" id="InputStartDate" name="start_date">
            </div>
            <div class="form-group col-md-3">
              <label for="InputEndDate">{{ __("End Date")}}:</label>
              <input type="date" class="form-control" id="InputEndDate" name="end_date">
            </div>
            
            <div class="form-group col-md-3">
              <label for="serachman">{{ __("Select Client")}}:</label>
                <select class="delivery-basic-single" id="serachman" name="serachman">
                  <option value="">Choose Delivery Man</option>
                    @foreach($deliverymen as $row)
                      <option value="{{$row->id}}" data-name="{{$row->user->name}}">{{$row->user->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-3">
              <button class="btn btn-primary search_btn mt-4" type="button">{{ __("Search")}}</button>
            </div>
        </div>
          
          
          <div class="table-responsive">
            <table class="table" id="waystable">
              <thead>
                <tr>
                  <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Assign Date")}}</th>
                        <th>{{ __("Client")}}</th>
                        <th>{{ __("Receiver Name")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                </tr>
              </thead>
              <tbody>
                
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
          <p><strong>{{ __("Receiver Name")}}:</strong> <span id="rname">Ma Mon</span></p>
          <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address")}}:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>
          <p><strong >{{ __("Item Price")}}:</strong><span id="rprice"> </span></p>
          <p><strong >{{ __("Delivery Fee")}}:</strong><span id="rdfee"> </span></p>
          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>
          <p><strong >{{ __("Total Amount")}}:</strong><span id="rtotal"> </span></p>

          <p id="error_remark" class="d-none"></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("OK")}}</button>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('.delivery-basic-single').select2({width:'100%'});

    $("#waystable tbody").on('click','.detail',function(){
      //alert("ok");
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

          if(res.error_remark != null){
            $('#error_remark').removeClass('d-none')
            $("#error_remark").html(`<strong>Date Changed Remark:</strong> <span class="text-warning">${res.error_remark}</span>`)
          };
          var price =  `${thousands_separators(res.deposit)}`;
          var deli_fee = `${thousands_separators(res.delivery_fees)}`;
          var total = res.deposit + res.delivery_fees;
          var total_amount = `${thousands_separators(total)}`;
          $('#rtotal').html(total_amount);
          $('#rprice').html(price);
          $('#rdfee').html(deli_fee);

          $(".rcode").html(res.codeno);
        })
      })

    $('.search_btn').click(function () {
        var sdate = $('#InputStartDate').val();
        var edate = $('#InputEndDate').val();
        var deliveryman_id=$("#serachman").val();
// console.log(start_date, end_date)
        var url="{{route('getwayhistory')}}";
        var i=1;
         $('#waystable').DataTable({
        "processing": true,
        "serverSide": true,
        destroy:true,
        "sort":false,
        "stateSave": true,
          "ajax": {
            url: url,
            type: "POST",
            data:{sdate:sdate,edate:edate,deliveryman_id:deliveryman_id},
            dataType:'json',
          },
          "columns": [
          {"data":'DT_RowIndex'},
          {"data": null,
          render:function(data, type, full, meta){
            if(data.status_code=="001"){
              return `${data.item.codeno}<span class="badge badge-info">{{'success'}}</span>`
            }else if(data.status_code=="002"){
               return `${data.item.codeno}<span class="badge badge-warning">{{'return'}}</span>`
            }else if(data.status_code=="003"){
              return `${data.item.codeno}<span class="badge badge-danger">{{'reject'}}</span>`
            }else{
              return `${data.item.codeno}`
            }
            
          }
        },
        {
          "data":"item.township.name"
        },
        {
          "data":"delivery_man.user.name"
        },
        {
          "data":"created_at",
          render:function(data){
            var date=new Date(data);
            date =date.toLocaleDateString(undefined, {year:'numeric'})+ '-' +date.toLocaleDateString(undefined, {month:'numeric'})+ '-' +date.toLocaleDateString(undefined, {day:'2-digit'})
             return date;
          }
        },

        {
          "data":"item.pickup.schedule.client.user.name"
        },
        {"data":"item.receiver_name"},
        {
          "data":"item.amount",
          render:function(data){
            return `${thousands_separators(data)}`
          }
        },
        {
          "data":null,
           render:function(data, type, full, meta){
            var wayediturl="{{route('deletewayassign',":id")}}"
           wayediturl=wayediturl.replace(':id',data.id);
            return`<a href="#" class="btn btn-primary detail" data-id="${data.item.id}">{{ __("Detail")}}</a>`
           }
        }
       ],
       "info":false
    });
        
      })

    function thousands_separators(num){
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

  })
</script>
@endsection
