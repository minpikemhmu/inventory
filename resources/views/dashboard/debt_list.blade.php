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
         <div class="alert alert-primary success d-none" role="alert"></div>
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">Debt List ({{$mytime->toFormattedDateString()}})</h3>
          
          <form method="post" action="{{route('fix_debit')}}">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="InputClient">Select Client:</label>
                <select class="form-control" id="InputClient" name="client">
                  <optgroup label="Select Client">
                    @foreach($clients as $client)
                      <option value="{{$client->id}}" data-name="{{$client->user->name}}">{{$client->user->name}}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
              <div class="form-group col-md-6 search_btn">
                <input type="hidden" name="noti" value="" id="notiid">
                <button class="btn btn-primary mt-4" type="submit">စာရင်းရှင်းမယ်</button>
              </div>
            </div>
          </form>

          <div id="debits">
            <span id="topay"></span>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Expense Type</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="debit_list">
                </tbody>
              </table>
            </div>

            <span id="toget"></span>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    {{-- <th>Township</th> --}}
                    <th>Delivery Fees</th>
                    <th>Deposit Amount</th>
                    <th>Total Amount</th>
                  </tr>
                </thead>
                <tbody id="reject_list">
                </tbody>
              </table>
            </div>
          </div>

          {{-- <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item Code</th>
                  <th>Delivery Men</th>
                  <th>Payment type</th>
                  <th>Debit Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                 @php $i=1@endphp
                @foreach($incomes as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td><span class="btn badge badge-primary btndetail" data-itemid="{{$row->way->item->id}}">{{$row->way->item->codeno}}</span></td>
                  <td>{{$row->way->delivery_man->user->name}}</td>
                  <td>{{$row->payment_type->name}}</td>
                  @if(!$row->delivery_fees)
                  <td>{{number_format($row->way->item->amount)}}KS</td>
                  @else
                  <td>{{number_format($row->way->item->deposit)}}KS</td>
                  @endif
                  <td><button class="btn btn-sm btn-success btndone" data-id="{{$row->id}}" data-amount="{{$row->way->item->amount}}" data-deli="{{$row->way->item->delivery_fees}}">done</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> --}}
        </div>
      </div>
    </div>
  </main>


  {{-- <div class="modal fade" id="detailmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Item Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="rejectitemdetail my-1">
                
            </div>
        </div>
    
      </div>
    </div>
  </div> --}}
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#debits').hide();
    $('.search_btn').hide();

    // $(".btndetail").click(function(){
    //   $("#detailmodal").modal("show");
    //   var item_id=$(this).data("itemid");
    //   //console.log(item_id);
    //   $.ajaxSetup({
    //      headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });
    //   var routeURL="{{route('rejectitem')}}";
    //   $.post(routeURL,{id:item_id},function(res){
    //     console.log(res);
    //     var html="";
    //     $.each(res,function(i,v){
    //        html+=`<h6 class="text-dark">Expire Date: <span class="text-danger">${v.expired_date}</span></h6>
    //           <h6 class="text-dark">Deposit Fee: <span>${thousands_separators(v.deposit)}Ks</span></h6>
    //           <h6 class="text-dark">Delivery Fee:<span>${thousands_separators(v.delivery_fees)}Ks</span></h6>
    //           <h6 class="text-dark">Client's Name:<span>${v.uname}</span></h6>
    //           <h6 class="text-dark">Contact Person:<span>${v.cperson}</span></h6>
    //           <h6 class="text-dark">Client's Phone:<span>${v.cphone}</span></h6>
    //           <h6 class="text-dark">Client's Full Address:<span>${v.caddress}</span></h6>`
    //     })
    //    $(".rejectitemdetail").html(html);

    //   })
    // })

    // $(".btndone").click(function(){
    //   //alert("ok");
    //   var id=$(this).data('id');
    //   var amount=$(this).data('amount');
    //   var deliamount=$(this).data('deli');
    //   console.log(id+" "+amount+" "+deliamount);
    //   $.ajaxSetup({
    //      headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });

    //   $.post('updateincome',{id:id,amount:amount,deliamount:deliamount},function(res){
    //     if(res=='success'){
    //       //alert("ok");
    //           $('.success').removeClass('d-none');
    //           $('.success').show();
    //           $('.success').text('successfully added to income list');
    //           $('.success').fadeOut(5000);
              
    //     }
    //   })
    // })

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('#InputClient').change(function () {
        var client_id = $(this).val();
        var clientname = $("#InputClient option:selected").text();
        //alert(clientname)
        var url = `/debit/getdebitlistbyclient/${client_id}`;
        $.get(url,function (response) {
          console.log(response)
          $("#notiid").val(response.rejectnoti);
          if (response.expenses.length > 0 || response.incomes.length > 0) {
            $('.search_btn').show();
          }else{
            $('.search_btn').hide();
          }
          var header = `<h4>ပေးရန် => ${clientname}:</h4>`;
          $('#topay').html(header);

          var footer = `<h4>ရရန် => ${clientname}:</h4>`;
          $('#toget').html(footer);

          let i = 1;
          var html = "";
          let total = 0;
          for(let row of response.expenses){
            html +=`<tr>
                    <td>${i++}</td>
                    <td>${row.description}</td>
                    <td>${row.expense_type.name}</td>
                    <td>${thousands_separators(row.amount)} Ks</td>
                  </tr>`;
                  total += Number(row.amount);
          }
          html +=`<tr>
                    <td colspan="3">Total: </td>
                    <td>${thousands_separators(total)} Ks</td>
                  </tr>`;

          let j=1;
          var html2="";
          let total2=totalreject=totalincome= 0;
          for(let row of response.rejects){
            console.log(row)
            let delivery_fees = 0;

            html2 +=`<tr>
                      <td>${j++}</td>
                      <td>${row.item.receiver_name}`; 
            if(row.status_code == '003')
                  html2 +=` <span class="badge badge-danger">reject</span>`;
          
            html2 +=`</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(row.item.deposit)}</td>
                      <td>${thousands_separators(row.item.deposit + delivery_fees)} Ks</td>
                  </tr>`;
                  totalreject += Number(row.item.deposit + delivery_fees);
          }

          for(let row of response.incomes){
            let delivery_fees=deposit=0;

            html2 +=`<tr>
                      <td>${j++}</td>
                      <td>${row.way.item.receiver_name}`;

            if(row.payment_type_id == 4){
              delivery_fees = Number(row.way.item.delivery_fees);
              deposit = Number(row.way.item.deposit);
              html2 +=` <span class="badge badge-info">All OS</span>`;
            }

            if(row.payment_type_id == 5){
              deposit = Number(row.way.item.deposit);
              html2 +=` <span class="badge badge-info">Only Deposit</span>`;
            }

            if(row.payment_type_id == 6){
              delivery_fees = Number(row.way.item.deposit);
              html2 +=` <span class="badge badge-info">Only Deposit</span>`;
            }

            html2 +=`</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(deposit)}</td>
                      <td>${thousands_separators(delivery_fees+deposit)} Ks</td>
                    </tr>`;
                  totalincome += Number(delivery_fees + deposit);
          }

          total2  = Number(totalreject)+Number(totalincome);

          html2 +=`<tr>
                    <td colspan="4">Total: </td>
                    <td>${thousands_separators(total2)} Ks</td>
                  </tr>`;

          $('#debits').show();
          $('#debit_list').html(html);
          $('#reject_list').html(html2);
        })
      })
  })
</script>
@endsection
