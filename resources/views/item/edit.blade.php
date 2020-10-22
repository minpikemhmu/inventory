@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i>Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}"> Items</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item Edit Form</h3>
          
          <form action="{{route('items.update',$item->id)}}" method="POST">
            @csrf
            @method('PUT')
             <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="InputCodeno">Codeno:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="{{$item->codeno}}" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="InputReceiverName">Receiver Name:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name" value="{{$item->receiver_name}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_name') }} </div>
                </div>


                <div class="form-group">
                  <label for="InputReceiverPhoneNumber">Receiver Phone Number:</label>
                  <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno" value="{{$item->receiver_phone_no}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_phoneno') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputReceiverAddress">Receiver Address:</label>
                  <textarea class="form-control" id="InputReceiverAddress" name="receiver_address">{{$item->receiver_address}}</textarea>
                   <div class="form-control-feedback text-danger"> {{$errors->first('receiver_address') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputReceiverTownship">Receiver Township:</label>
                  <select class="form-control mytownship" id="InputReceiverTownship" name="receiver_township">
                    <optgroup label="Choose Township">
                      <option>Choose township</option>
                      @foreach($townships as $row)
                      <option value="{{$row->id}}" @if($item->township_id==$row->id) selected @endif>{{$row->name}}</option>
                      @endforeach
                    </optgroup>
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputExpiredDate">Expired Date:</label>
                  <input class="form-control" id="InputExpiredDate" type="date" name="expired_date"  value="{{$item->expired_date}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('expired_date') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeposit">Deposit:</label>
                  <input class="form-control" id="InputDeposit" type="number" name="deposit" value="{{$item->deposit}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('deposit') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeliveryFees">Delivery Fees:</label>
                  <input class="form-control" id="InputDeliveryFees" type="number" name="delivery_fees" value="{{$item->delivery_fees}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('delivery_fees') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputAmount">Amount: (deposit+delivery fees+others)</label>
                  <input class="form-control" id="InputAmount" type="number" name="amount" value="{{$item->amount}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputRemark">Remark:</label>
                  <textarea class="form-control" id="InputRemark" name="remark">{{$item->remark}}</textarea>
                  <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
                </div>
              </div>

            <div class="form-group">
              <button class="btn btn-primary mx-3" type="submit">Save</button>
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

    $("#InputDeposit").change(function(){
      var deposit=parseInt($(this).val());
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      var amount=deposit+delivery_fees;
      $("#InputAmount").val(amount);
    })
  })
</script>
@endsection