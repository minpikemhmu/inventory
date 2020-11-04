@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Financial Statements</h1>
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
          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Income</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Expense</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profit">Profit</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="home">
                <div class="row col-12">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                <input type="date" name="" class="form-control start-date">
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                <input type="date" name="" class="form-control end-date">
                </div>
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                 <button class="btn btn-success search">Search</button>
                </div>
              </div>
              <div class="table-responsive mytable">
              <table class="table searchTable" id="incometable">
                  <thead>
                    <tr>
                      
                      <th>Item Code</th>
                      <th>Delivery Men</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    </tbody>
                </table>
              </div>
              </div>
              <div class="tab-pane fade" id="profile">
                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
              </div>
              <div class="tab-pane fade" id="profit">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function (argument) {
      $(".mytable").hide();
      $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
      $('.search').click(function (argument) {
        $(".mytable").show();
        var start_date = $('.start-date').val();
        var end_date = $('.end-date').val();
// console.log(start_date, end_date)
        var url="{{route('incomesearch')}}";
        var i=1;
         $('#incometable').DataTable( {
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

        { "data": "item_code",
        render:function(data){
                    //console.log(data);
                   return `<span class="btn badge badge-primary">${data}</span>`
                  } },
        { "data": "delivery_man" },
         { "data": "amount" }
        ],
        "info":false
    } );
         
      })
      
      
    })
  </script>
  @endsection

