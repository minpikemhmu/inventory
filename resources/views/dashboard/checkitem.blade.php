@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Items")}}</h1>
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
          <h3 class="tile-title d-inline-block">{{ __("Total Deposit Amount")}}: {{number_format($checkitems[0]->pickup->schedule->amount)}} Ks</h3>
          @php $i=1;$j=1;  @endphp
          <div class="bs-component">
                <div class="table-responsive">
                  <table class="table table-bordered" id="checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Receiver Name")}}</th>
                        <th>{{ __("Receiver Township")}}</th>
                        <th>{{ __("Receiver Phone No")}}</th>
                        <th>{{ __("Remark")}}</th>
                        <th>{{ __("Deposit Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody class="mytbody">
                      
                      @foreach($checkitems as $row)
                      <tr>
                      <td>{{$i++}}</td>
                      <td>{{$row->codeno}}</td>
                      <td>{{$row->receiver_name}}</td>
                      <td>{{$row->township->name}}</td>
                      <td>{{$row->receiver_phone_no}}</td>
                      <td>{{$row->remark}}</td>
                      <td class="mytd"><input type="number" class="form-control checkitemamount{{$j++}}" name="amount" value="@if($row->deposit){{$row->deposit}}@else{{0}}@endif"  data-id="{{$row->id}}" @if($row->deposit == null){{'readonly'}}@endif></td>
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

      $('#checktable').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "bStateSave": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1,0] }
            ]
        });

      $(".checkitemsave").click(function(){

      var count=$("#count").val();
      //alert(count);
      var totaldeposit=$("#totaldeposit").val()
      //console.log(totaldeposit);

      var myarray=[];
      for(var i=1;i<=count;i++){
      var oTable = $('#checktable').dataTable();
     // console.log(oTable);
      var rowcollection =  oTable.$(".checkitemamount"+i, {"page": "all"});
      //console.log(rowcollection);
      rowcollection.each(function(index,elem){
           var checkamount=$(elem).val();
           var checkid=$(elem).data('id');
           //console.log(checkid);

           var checkobj={
          id:checkid,
          amount:checkamount
        }
        myarray.push(checkobj);
      //console.log(myarray);
        });

      }

      var total=0;
     // console.log(myarray);
      myarray.forEach( function(v, i) {
       total+=parseInt(v.amount);
      });
      //alert(total);

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