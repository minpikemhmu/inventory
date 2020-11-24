@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">Items</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item Create Form</h3>
          @if(session('successMsg') != NULL)
            <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
                <strong> ✅ SUCCESS!</strong>
                {{ session('successMsg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif
          <form method="POST" action="{{route('items.store')}}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputCodeno">Codeno:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="{{$itemcode}}" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="InputReceiverName">Receiver Name:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name" value="{{ old('receiver_name') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_name') }} </div>
                </div>


                <div class="form-group">
                  <label for="InputReceiverPhoneNumber">Receiver Phone Number:</label>
                  <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno" value="{{ old('receiver_phoneno') }}" >
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_phoneno') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputReceiverAddress">Receiver Address:</label>
                  <textarea class="form-control" id="InputReceiverAddress" name="receiver_address">{{ old('receiver_address') }}</textarea>
                   <div class="form-control-feedback text-danger"> {{$errors->first('receiver_address') }} </div>
                </div>

                <div class="row my-3">
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="incity" value="1" checked="checked">
                  <label class="form-check-label" for="incity">
                    In city
                  </label>
                </div>
              </div>

              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="gate" value="2" >
                  <label class="form-check-label" for="gate">
                    Gate
                  </label>
                </div>
              </div>

              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="post" value="3" >
                  <label class="form-check-label" for="post">
                    Post Office
                  </label>
                </div>
              </div>
              <div class="form-control-feedback text-danger"> {{$errors->first('rcity') }} </div>
            </div>

            <div class="form-group township">
                  <label for="InputReceiverTownship">Receiver Township:</label><br>
                  <select class="js-example-basic-single  mytownship" id="InputReceiverTownship" name="receiver_township"  >
                    <option>Choose toenship</option>
                    @foreach($townships as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
               </div>

                <div class="form-group">
                  <label for="txtDate">Expired Date:</label>
                  <input class="form-control pickdate" id="txtDate" type="date" name="expired_date"  value="@if($pickupeditem){{ $pickupeditem->expired_date }}@else{{old('expired_date')}}@endif">
                  <div class="form-control-feedback text-danger"> {{$errors->first('expired_date') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeposit">Deposit:</label>
                  <input class="form-control" id="InputDeposit" type="number" name="deposit" value="@if($pickupeditem){{ $pickupeditem->deposit }}@else {{old('deposit')}} @endif">
                  <div class="form-control-feedback text-danger"> {{$errors->first('deposit') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeliveryFees">Delivery Fees:</label>
                  <input class="form-control" id="InputDeliveryFees" type="number" name="delivery_fees" value="{{ old('delivery_fees') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('delivery_fees') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputAmount">Amount: (deposit+delivery fees+others)</label>
                  <input class="form-control" id="InputAmount" type="number" name="amount" value="{{ old('amount') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputRemark">Remark:</label>
                  <textarea class="form-control" id="InputRemark" name="remark">@if($pickupeditem){{ $pickupeditem->remark }} @else {{old('remark')}} @endif</textarea>
                  <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
                </div>
              </div>
              <div class="col-md-6">
                <input type="hidden" name="pickup_id" value="{{$pickup->id}}">

                <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">Client Informations:</h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Name: {{$client->user->name}}</li>
                    <li class="list-group-item">Contact Person: {{$client->contact_person}}</li>
                    <li class="list-group-item">Phone Number: {{$client->phone_no}}</li>
                    <li class="list-group-item">Township: {{$client->township->name}}</li>
                    <li class="list-group-item">Left Item to collect: {{$pickup->schedule->quantity - count($pickup->items)}}</li>

                    @php
                    $total=0;
                   
                    @endphp
                    @foreach($pickup->items as $pickupitem)
                     @php $total+=$pickupitem->deposit @endphp
                    @endforeach
                    <input type="hidden" name="client_id" value="{{$client->id}}">

                    <input type="hidden" name="depositamount" value="{{$pickup->schedule->amount}}" class="depositamount">
                    <input type="hidden" name="qty" value={{$pickup->schedule->quantity - count($pickup->items)}}>
                    <input type="hidden" name="myqty" value="{{$pickup->schedule->quantity}}">
                    <li class="list-group-item">Deposit for all item: {{number_format($pickup->schedule->amount-$total)}}KS</li>
                    @if($pickup->schedule->quantity - count($pickup->items) == 1)
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="paystatus" id="paid" value="1" checked="checked">
                            <label class="form-check-label" for="paid">
                              Paid
                            </label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="col-6">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="paystatus" id="unpaid" value="2" >
                              <label class="form-check-label" for="unpaid">
                                Unpaid
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-control-feedback text-danger"> {{$errors->first('paystatus') }} </div>
                        </div>
                      </div>
                    </li>
                    @endif
                  </ul>
                </div>

                <img src="{{asset($pickup->schedule->file)}}" class="img-fluid">
              </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    // $(".township").hide();
    // for in city
    var today = new Date();
    var numberofdays = 3;
    today.setDate(today.getDate() + numberofdays); 
    var day = ("0" + today.getDate()).slice(-2);
    var month = ("0" + (today.getMonth() + 1)).slice(-2);
    //console.log(month);
    var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
    console.log(incityday);
    $(".pickdate").val(incityday);


    $(".mytownship").change(function(){
      var id=$(this).val();
      //console.log(id);
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      $.post("/delichargebytown",{id:id},function(res){
        $("#InputDeliveryFees").val(res);

      })
    })

    $("#InputAmount").focus(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamount").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $(this).val(amount);
      }
     
    })
    
    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        //alert(maxDate);
        $('#txtDate').attr('min', maxDate);
    });

    $("input[name=rcity]").click(function(){
    if ($(this).is(':checked'))
    {
      $(".township").show();
      var id=$(this).val();

      if(id==1){
        var today = new Date();
        var numberofdays = 3;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        console.log(incityday);
        $(".pickdate").val(incityday);
        $('#InputDeposit').prop('disabled',false);
      }else{
        var today = new Date();
        var numberofdays = 7;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var gateday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        console.log(gateday);
        $(".pickdate").val(gateday);
        $("#InputDeposit").val(0);
        $('#InputDeposit').prop('disabled',true);
      }

      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      $.post("/townshipbystatus",{id:id},function(res){
       // console.log(res);
        var html="";
        html+=`<option>Choose township</option>`
        $.each(res,function(i,v){
          html+=`<option value="${v.id}">${v.name}</option>`
        })
        $("#InputReceiverTownship").html(html);
      })
    }
  });

     $('.js-example-basic-single').select2({width:'100%'});
  })
</script>
@endsection