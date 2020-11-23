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
          @role('staff|admin')
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
          @endrole

          @role('client')
            <div class="bs-component">
              <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pay">ပေးရန်</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#get">ရရန်</a></li>
              </ul>
              <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade active show" id="pay">
                  <div class="table-responsive">
                    <table class="table table-bordered dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Delivery Fees</th>
                          <th>Deposit Amount</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; $total=0; @endphp
                        @foreach($incomes as $income)
                          @php $delifees = 0; @endphp
                          @if($income->payment_type_id == 5)
                            @php $delifees = 0; @endphp
                          @else
                            @php $delifees = $income->way->item->delivery_fees; @endphp
                          @endif
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$income->way->item->receiver_name}} <span class="badge badge-dark">{{$income->receiver_phone_no}}</span></td>
                            <td>{{$income->payment_type->name}}</td>
                            <td>
                              {{number_format($delifees)}}
                            </td>
                            <td>{{number_format($income->way->item->deposit)}}</td>
                            <td>{{number_format($delifees + $income->way->item->deposit)}}</td>
                            @php $total += ($delifees + $income->way->item->deposit); @endphp
                          </tr>
                        @endforeach
                        @foreach($rejects as $reject)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$reject->way->item->receiver_name}} <span class="badge badge-dark">{{$reject->receiver_phone_no}}</span></td>
                            <td>{{$reject->payment_type->name}}</td>
                            <td>{{number_format($reject->way->item->delivery_fees)}}</td>
                            <td>{{number_format($reject->way->item->deposit)}}</td>
                            <td>{{number_format($reject->way->item->delivery_fees + $reject->way->item->deposit)}}</td>
                            @php $total += ($reject->way->item->delivery_fees + $reject->way->item->deposit); @endphp
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5">Total:</td>
                          <td>{{number_format($total)}} Ks</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="get">
                  <div class="table-responsive">
                    <table class="table table-bordered dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Description</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; $etotal=0; @endphp
                        @foreach($expenses as $expense) 
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$expense->description}}</td>
                          <td>{{number_format($expense->amount)}}</td>
                          @php $etotal += $expense->amount; @endphp
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2">Total:</td>
                          <td>{{number_format($etotal)}} Ks</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endrole
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#debits').hide();
    $('.search_btn').hide();

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
