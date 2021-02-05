@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Items")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">{{ __("Items")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        @if(session('successMsg') != NULL)
          <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
              <strong> ✅ SUCCESS!</strong>
              {{ session('successMsg') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        <div class="tile">
          <h3 class="tile-title d-inline-block">{{ __("Item List")}}</h3>
          <a href="#" class="btn btn-primary float-right wayassign" id="submit_assign">{{ __("Way Assign")}}</a>

          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#collect">{{ __("In Stock")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#way">{{ __("On Ways")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#print">{{ __("Print Ways")}}</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

              {{-- instock --}}
              <div class="tab-pane fade active show" id="collect">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Client Name")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Receiver Info")}}</th>
                        <th>{{ __("Expired Date")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody class="itemtbody">
                      
                    </tbody>
                  </table>
                </div>
              </div>

              {{-- onway --}}
              <div class="tab-pane fade" id="way">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="onwaytable">
                    <thead>
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
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>

              {{--  print --}}
              <div class="tab-pane fade" id="print">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>{{ __("Choose Delivery Man")}}:</label>
                      <select class="deliverymanway form-control" name="delivery_man">
                        @foreach($deliverymen as $man)
                        <option value="{{$man->id}}">{{$man->user->name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>{{ __("Item Code")}}</th>
                        <th>{{ __("Receiver Name")}}</th>
                        <th>{{ __("Full Address")}}</th>
                        <th>{{ __("Receiver Phone No")}}</th>
                        <th>{{ __("Client")}}</th>
                        <th>{{ __("Amount")}}</th>
                      </tr>
                    </thead>

                    <tbody class="tbody">
                     
                    </tbody>
                  </table>
                </div>

                <form action="{{route("createpdf")}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="" id="exportid">
                  <div class="justify-content-end mb-4" id="export">
                    <button type="submit" class="btn btn-primary exportpdf">Export to PDF</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Ways Assign modal --}}
  <div class="modal fade" id="wayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Choose Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('wayassign')}}" onsubmit="return checkForm(this);">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __("Way Code Numbers")}}:</label>
              <div id="selectedWays"></div>
            </div>
            <div class="form-group">
              <label>{{ __("Choose Delivery Man")}}:</label>
              <select class="js-example-basic-multiple form-control" name="delivery_man">
                @foreach($deliverymen as $man)
                  <option value="{{$man->id}}">{{$man->user->name}}
                  @foreach($man->townships as $township)
                    ({{$township->name}})
                  @endforeach</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Edit Ways Assign modal --}}
  <div class="modal fade" id="editwayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Choose Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('updatewayassign')}}">
          @csrf
          <input type="hidden"  id="wayid" name="wayid">
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __("Choose Delivery Man")}}:</label>
              <select class="js-example-basic-single form-control" name="delivery_man">
                @foreach($deliverymen as $man)
                  <option value="{{$man->id}}">{{$man->user->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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
    $(document).ready(function () {

      function checkForm(form) // Submit button clicked
      {
        //
        // check form input values
        //

        form.myButton.disabled = true;
        form.myButton.value = "Please wait...";
        return true;
      }

      $("#export").hide();
      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
      $('.wayassign').click(function () {
        var ways = [];
        var oTable = $('#checktable').dataTable();
        // console.log(oTable);
        var rowcollection = oTable.$("input[name='assign[]']:checked", {"page": "all"});
        console.log(rowcollection);
        $.each(rowcollection,function(index,elem){
          let wayObj = {id:$(elem).val(),codeno:$(elem).data('codeno')};
          ways.push(wayObj);
        });

        // console.log(ways)
        var html="";
        for(let way of ways){
          html+=`<input type="hidden" value="${way.id}" name="ways[]"><span class="badge badge-primary mx-2">${way.codeno}</span>`;
        }
        $('#selectedWays').html(html);

        $('#wayAssignModal').modal('show');
      })


      //item detail
      $("#onwaytable tbody").on('click','.detail',function(){
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
          var total = Number(res.deposit) + Number(res.delivery_fees);
          var total_amount = `${thousands_separators(total)}`;
          $('#rtotal').html(total_amount);
          $('#rprice').html(price);
          $('#rdfee').html(deli_fee);

          $(".rcode").html(res.codeno);
        })
      })


      //check detail

      $("#checktable tbody").on('click','.detail',function(){
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
          var price = `${thousands_separators(res.deposit)}`;
          var deli_fee = `${thousands_separators(res.delivery_fees)}`;
          var total = Number(res.deposit) + Number(res.delivery_fees);
          var total_amount = `${thousands_separators(total)}`;
          $('#rtotal').html(total_amount);
          $('#rprice').html(price);
          $('#rdfee').html(deli_fee);
          $(".rcode").html(res.codeno);
        })
      })
      $('.js-example-basic-multiple').select2({
        width: '100%',
        dropdownParent: $('#wayAssignModal')
      });

      $('.js-example-basic-single').select2({
        width: '100%',
        dropdownParent: $('#editwayAssignModal')
      });


       $('.deliverymanway').select2({
        width: '100%',
      })

      var submit = $("#submit_assign").hide();
      cbs = $('#checktable tbody').on('click', 'input[name="assign[]"]', function () {
      // cbs = $('input[name="assign[]').click(function() {
      // submit.toggle(cbs.is(":checked") , 2000);
      // submit.toggle(cbs.is(":checked"));

        if($('#checktable tbody :input[type="checkbox"]:checked').length>0)
        {
          $("#submit_assign").show();
        }else{
          $("#submit_assign").hide();
        }
        // submit.toggle();
        //console.log(submit)
      });
      // console.log($cbs)

    $("#onwaytable tbody").on('click','.wayedit',function(){
        $('#editwayAssignModal').modal('show');
        var id=$(this).data("id");
        //console.log(id);
        $("#wayid").val(id);
      })


     /*setTimeout(function(){
      window.location.reload(1);
    }, 90000);*/


    $(".deliverymanway").change(function(){
      //alert("ok");
      var id=$(this).val();
      //console.log(id);
      var url="{{route('waybydeliveryman')}}";

       $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

      $.post(url,{id:id},function(res){
        var html="";
        console.log(res);
        $.each(res,function(i,v){
          html+=`<tr>
                <td>${v.item.codeno}</td>
                <td>${v.item.receiver_name}</td>
                <td>${v.item.receiver_address}</td>
                <td>${v.item.receiver_phone_no}</td>
                <td>${v.item.pickup.schedule.client.user.name}</br>(${v.item.pickup.schedule.client.phone_no})</td>
                <td>${v.item.amount}</td>
              </tr>`
        })
        $(".tbody").html(html);
        if(res.length==0){
           $("#export").hide();
        }else{
          $("#export").show();
        }
       
        $("#exportid").val(id);
      })

    })

      getdata();
      getway();

      function getdata(){   
        var url="{{route('newitem')}}";
        var i=1;
        $('#checktable').dataTable({
          "pageLength": 100,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "bStateSave": true,
          "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ -1,0] }
          ],
          "bserverSide": true,
          "bprocessing":true,
          "ajax": {
            url: url,
            type: "GET",
            dataType:'json',
          },
          "columns": [
            {"data": null,
              render:function(data, type, full, meta){

                return`<div class="animated-checkbox">
                <label class="mb-0">
                <input type="checkbox" name="assign[]" value="${data.id}" data-codeno="${data.codeno}"><span class="label-text"> </span>
                </label>
                </div>`
              }
            },
            {"data":"codeno"},
            {
              "data":"pickup.schedule.client.user.name"
            },
            {
              "data":"township.name"
            },
            {
              "data":null,
              render:function(data, type, full, meta){

                return`<span class="d-block">${data.receiver_name}</span>
                        <span class="badge badge-dark">${data.receiver_phone_no}</span>`
              }
            },
            {"data":null,
              render:function(data, type, full, meta){
                if(data.error_remark!=null){

                  return`<span class="d-block">${formatDate(data.expired_date)}</span>
                        <span class="badge badge-warning">{{ __("date changed")}}</span>`;
                }
                else{
                  return formatDate(data.expired_date);
                }
              }
            },
            {
              "data":null,
              render:function(data, type, full, meta){
                  return thousands_separators(data.amount);
                }
            },
            {
              "data":null,
              render:function(data, type, full, meta){
               var editurl="{{route('items.edit',":id")}}"
               editurl=editurl.replace(':id',data.id);
               return`<a href="#" class="btn btn-sm btn-primary detail" data-id="${data.id}">{{ __("Detail")}}</a> <a href="${editurl}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>`
              }
            }
          ],
          "info":false
        });
      }

      function getway(){   
        var url="{{route('onway')}}";
        $('#onwaytable').dataTable({
          "pageLength": 100,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "bStateSave": true,
          "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ -1,0] }
          ],
          "bserverSide": true,
          "bprocessing":true,
          "ajax": {
            url: url,
            type: "GET",
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
                return formatDate(data);
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
                var waydeleteurl="{{route('deletewayassign',":id")}}"
                waydeleteurl=waydeleteurl.replace(':id',data.id);
                var wayediturl="{{route('items.edit',":id")}}"
                wayediturl=wayediturl.replace(':id',data.item.id);
                return `<a href="#" class="btn btn-sm btn-primary detail" data-id="${data.item.id}">{{ __("Detail")}}</a>
               <a href="${wayediturl}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
              <a href="${waydeleteurl}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">{{ __("Delete")}}</a>`
               }
            }
          ],
          "info":false
        });
      }

      function thousands_separators(num){
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
      }

      // Y/M/D into D/M/Y
      function formatDate (input) {
        var datePart = input.match(/\d+/g),
        year = datePart[0].substring(0,4), // get only two digits
        month = datePart[1], day = datePart[2];
        return day+'-'+month+'-'+year;
      }

    })

   
  </script>
@endsection