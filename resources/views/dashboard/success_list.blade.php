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
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">Success List ({{$mytime->toFormattedDateString()}})</h3>

<form  method="post" class="myform">
  @csrf
          <button class="btn btn-info btn-lg float-right generate">Generate Report</button>

           <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                    <input type="date" name="start_date" class="form-control start-date">
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                    <input type="date" name="end_date" class="form-control end-date">
                  </div>
                  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                    <button class="btn btn-success search">Search</button>
                  </div>
             </div>
  </form>
          <div class="table-responsive">
            <table class="table" id="waystable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Delivery man</th>
                  <th>pickups</th>
                  <th>ways</th>
                  <th>Total</th>
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
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    $(".search").click(function(e){
      e.preventDefault();
      var start_date = $('.start-date').val();
      var end_date = $('.end-date').val();
      //alert("ok");
      var month=$("#InputMonth").val();
      var deliveryman=$("#InputDeliveryMan").val();
      //console.log(month);
      $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
      
      var url="{{route('waysreport')}}";
        $('#waystable').DataTable( {
        "processing": true,
        "serverSide": true,
        destroy:true,
        "sort":false,
        "stateSave": true,
        "ajax": {
            url: url,
            type: "POST",
            data:{start_date:start_date,end_date:end_date},
            dataType:'json',
        },
        "columns": [
         {"data":'DT_RowIndex'},
        { "data": "user.name"},
        {
          "data": "pickups",
          render:function(data){
                    return data.length;
                  }
          },
          {
          "data": "ways",
          render:function(data){
             return data.length;
                  }
          },
          {
            "data": null,
            "render": function(data, type, full, meta){
             var mydata=full["ways"].length+full["pickups"].length;
             return mydata;
            }
         }

        ],
        "info":false
    } );
    })

    $(".generate").click(function(e){
      $(".myform").attr('action',"{{route('successreport')}}")
    })

  })
</script>
@endsection