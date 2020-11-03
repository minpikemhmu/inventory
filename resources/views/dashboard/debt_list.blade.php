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
          <div class="table-responsive">
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
                  <td>{{$row->way->item->amount}}KS</td>
                  @else
                  <td>{{$row->way->item->deposit}}KS</td>
                  @endif
                  <td><button class="btn btn-sm btn-success btndone" data-id="{{$row->id}}" data-amount="{{$row->way->item->amount}}" data-deli="{{$row->way->item->delivery_fees}}">done</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>


  <div class="modal fade" id="detailmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $(".btndetail").click(function(){
      $("#detailmodal").modal("show");
      var item_id=$(this).data("itemid");
      //console.log(item_id);
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      var routeURL="{{route('rejectitem')}}";
      $.post(routeURL,{id:item_id},function(res){
        console.log(res);
        var html="";
        $.each(res,function(i,v){
           html+=`<h6 class="text-dark">Expire Date: <span class="text-danger">${v.expired_date}</span></h6>
              <h6 class="text-dark">Deposit Fee: <span>${v.deposit}Ks</span></h6>
              <h6 class="text-dark">Delivery Fee:<span>${v.delivery_fees}Ks</span></h6>
              <h6 class="text-dark">Client's Name:<span>${v.uname}</span></h6>
              <h6 class="text-dark">Contact Person:<span>${v.cperson}</span></h6>
              <h6 class="text-dark">Client's Phone:<span>${v.cphone}</span></h6>
              <h6 class="text-dark">Client's Full Address:<span>${v.caddress}</span></h6>`
        })
       $(".rejectitemdetail").html(html);

      })
    })

    $(".btndone").click(function(){
      //alert("ok");
      var id=$(this).data('id');
      var amount=$(this).data('amount');
      var deliamount=$(this).data('deli');
      console.log(id+" "+amount+" "+deliamount);
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

      $.post('updateincome',{id:id,amount:amount,deliamount:deliamount},function(res){
        if(res=='success'){
          //alert("ok");
              $('.success').removeClass('d-none');
              $('.success').show();
              $('.success').text('successfully added to income list');
              $('.success').fadeOut(5000);
              
        }
      })
    })
  })
</script>
@endsection