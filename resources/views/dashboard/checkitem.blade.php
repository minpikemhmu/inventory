@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      
    </div>
    <div class="row">
      <div class="col-md-12">
        @if(!empty($successMsg))
          <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
              <strong> ✅ Fail!</strong>
              {{ $successMsg }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        <div class="tile">
          <h3 class="tile-title d-inline-block">Total Deposit Amount: {{number_format($checkitems[0]->pickup->schedule->amount)}} Ks</h3>
          
          <div class="bs-component">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Codeno</th>
                        <th>Reciver Township</th>
                        <th>Reciver Address</th>
                        <th>Reciver Phoneno</th>
                        <th>Remark</th>
                        <th>Deposit Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1;$j=1;
                      @endphp
                     
                      @foreach($checkitems as $row)
                      <tr>
                      <td>{{$i++}}</td>
                      <td>{{$row->codeno}}</td>
                      <td>{{$row->receiver_name}}</td>
                      <td>{{$row->receiver_address}}</td>
                      <td>{{$row->receiver_phone_no}}</td>
                      <td>{{$row->remark}}</td>
                      <td><input type="number" class="form-control checkitemamount{{$j++}}" name="amount" value="@if($row->deposit){{$row->deposit}}@else{{0}}@endif"  data-id="{{$row->id}}" @if($row->deposit == null){{'readonly'}}@endif></td>
                      @endforeach
                      
                    </tr>
                      
                    </tbody>
                  </table>
                  <input type="hidden" name="totalamount" value="{{$checkitems[0]->pickup->schedule->amount}}" id="totaldeposit">
                  <input type="hidden" name="count" id="count" value="{{count($checkitems)}}">
                  <button class="btn btn-primary checkitemsave">Save</button>

                </div>
              
           
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
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);

    $(".checkitemsave").click(function(){
      var count=$("#count").val();
      //console.log(count);
      var totaldeposit=$("#totaldeposit").val()
      //console.log(totaldeposit);

      var myarray=[];
      for(var i=1;i<=count;i++){
        var checkamount= $(".checkitemamount"+i).val();
        var checkid= $(".checkitemamount"+i).data('id');
        console.log(checkamount);
        var checkobj={
          id:checkid,
          amount:checkamount
        }
        myarray.push(checkobj);
      }

      var total=0;
      //console.log(myarray);
      myarray.forEach( function(v, i) {
       total+=parseInt(v.amount);
      });
      //console.log(total);

      if(totaldeposit==total){
        $.ajaxSetup({
           headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.post("/updateamount",{myarray:myarray},function(res){
          if(res){
            location.href="{{route('items.index')}}"
          }
        })
      }else{
        alert("amounts are not match");
      }
    })

  })
  
</script>
@endsection