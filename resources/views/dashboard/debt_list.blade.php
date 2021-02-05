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
          <h3 class="tile-title d-inline-block">{{ __("Debt List")}} ({{$mytime->toFormattedDateString()}})</h3>
          @role('staff|admin')
          
            <div class="row">
              <div class="form-group col-md-3">
                <label for="InputClient">{{ __("Select Client")}}:</label>
                <select class="form-control" id="InputClient" name="client">
                  <optgroup label="Select Client">
                    @foreach($clients as $client)
                      <option value="{{$client->id}}" data-name="{{$client->clientname}}" data-owner="{{$client->owner}}" data-account="{{$client->account}}">{{$client->clientname}}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
              <div class="form-group col-md-3 search_btn d-none">
                <button class="btn btn-primary mt-4 fix_debit" type="button">စာရင်းရှင်းမယ်</button>
              </div>
              <div class="form-group col-md-3 account">
                
              </div>
              <div class="form-group col-md-3 owner">
                
              </div>
            </div>
          
          <div id="debits">
            <span id="topay"></span>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{ __("Pickup Date")}}</th>
                    <th>{{ __("Item Qty")}}</th>
                    <th>{{ __("Total Amount")}}</th>
                    <th>{{ __("Prepaid Amount")}}</th>
                    <th>{{ __("Balance")}}</th>
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
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Name")}}</th>
                    <th>{{ __("Collect Date")}}</th>
                    <th>{{ __("Delivery Fees")}}</th>
                    <th>{{ __("Deposit Amount")}}</th>
                    <th>{{ __("Bus Gate / Other Charges")}}</th>
                    <th>{{ __("Total Amount")}}</th>
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
                          <th>{{ __("Name")}}</th>
                          <th>{{ __("Description")}}</th>
                          <th>{{ __("Delivery Fees")}}</th>
                          <th>{{ __("Deposit Amount")}}</th>
                          <th>{{ __("Total Amount")}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; $total=0; @endphp
                        @foreach($incomes as $income)
                          @php $delifees = 0; $deposit=0;@endphp
                          @if($income->payment_type_id == 5)
                            @php $delifees = 0; @endphp
                          @else
                            @php $delifees = $income->way->item->delivery_fees; @endphp
                          @endif

                          @if($income->payment_type_id == 6)
                            @php $deposit = 0; @endphp
                          @else
                            @php $deposit = $income->way->item->deposit; @endphp
                          @endif
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$income->way->item->receiver_name}} <span class="badge badge-dark">{{$income->way->item->receiver_phone_no}}</span></td>
                            <td>{{$income->payment_type->name}}</td>
                            <td>
                              {{number_format($delifees)}}
                            </td>
                            <td>{{number_format($deposit)}}</td>
                            <td>{{number_format($delifees + $deposit)}}</td>
                            @php $total += ($delifees + $deposit); @endphp
                          </tr>
                        @endforeach
                        @foreach($rejects as $reject)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$reject->item->receiver_name}} <span class="badge badge-dark">{{$reject->item->receiver_phone_no}}</span></td>
                            <td>{{'Reject'}}</td>
                            <td>{{number_format(0)}}</td>
                            <td>{{number_format($reject->item->deposit)}}</td>
                            <td>{{number_format(0 + $reject->item->deposit)}}</td>
                            @php $total += (0 + $reject->item->deposit); @endphp
                          </tr>
                        @endforeach
                        @foreach($carryfees as $carryfee)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$carryfee->item->receiver_name}} <span class="badge badge-dark">{{$carryfee->item->receiver_phone_no}}</span></td>
                            <td>{{'Carry Fees'}}</td>
                            <td>{{number_format(0)}}</td>
                            <td>{{number_format($carryfee->amount)}}</td>
                            <td>{{number_format($carryfee->amount)}}</td>
                            @php $total += $carryfee->amount; @endphp
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5">{{ __("Total")}}:</td>
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
                          <th>{{ __("Description")}}</th>
                          <th>{{ __("Amount")}}</th>
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
                          <td colspan="2">{{ __("Total")}}:</td>
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

  <!-- Modal -->
  <div class="modal fade" id="fixDebitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Choose Payment Method:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('fix_debit')}}">
          @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="col-md-4">
              <label>Choose Bank or Cash:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control payment_method" name="payment_method">
                {{-- <option value="" data-amount="0">Choose Bank</option> --}}
                @foreach($banks as $bank)
                <option value="{{$bank->id}}" data-amount="{{$bank->amount}}">{{$bank->name}} ({{$bank->amount}})</option>
                @endforeach
              </select>
            </div>
            <div class="checked_debt_list">
            </div>
          </div>
          <input type="hidden" name="client" value="" id="client_id">
          <input type="hidden" name="noti" value="" id="notiid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Fix Debit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#debits').hide();
    // $('.search_btn').hide();

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('.fix_debit').click(function () {
      let expenses = [];
      let rejects = [];
      let incomes = []; 
      let carryfees = [];
      $("input:checkbox[name='expenses[]']:checked").each(function() { 
          let expense_obj = {id:$(this).val(),amount:$(this).data('amount')}
          expenses.push(expense_obj);
      });
      $("input:checkbox[name='rejects[]']:checked").each(function() { 
          let reject_obj = {id:$(this).val(),amount:$(this).data('amount')}
          rejects.push(reject_obj);
      });
      $("input:checkbox[name='incomes[]']:checked").each(function() { 
          let income_obj = {id:$(this).val(),amount:$(this).data('amount')}
          incomes.push(income_obj);
      });
      $("input:checkbox[name='carryfees[]']:checked").each(function() { 
          let carryfee_obj = {id:$(this).val(),amount:$(this).data('amount')}
          carryfees.push(carryfee_obj);
      });
      // console.log(expenses)
      let totalexpenses = expenses.reduce((a, c) => (a + c.amount),0)
      let totalincomes = rejects.reduce((a, c) => (a + c.amount),0) + incomes.reduce((a, c) => (a + c.amount),0) + carryfees.reduce((a, c) => (a + c.amount),0)

      if ((totalexpenses+totalincomes) > 0){
        let html = `<input type="hidden" name="expenses" value='${JSON.stringify(expenses)}'>
                <input type="hidden" name="rejects" value='${JSON.stringify(rejects)}'>
                <input type="hidden" name="incomes" value='${JSON.stringify(incomes)}'>
                <input type="hidden" name="carryfees" value='${JSON.stringify(carryfees)}'>
                <p>ပေးရန် => ${thousands_separators(totalexpenses)}</p>
                <p>ရရန် => ${thousands_separators(totalincomes)}</p>
                <p>လက်ကျန် => ${thousands_separators(totalexpenses-totalincomes)}</p>
                <input type="hidden" name="balance" value='${totalexpenses-totalincomes}'>`;
                ;
        $('.checked_debt_list').html(html);
        $('#fixDebitModal').modal('show');
      }else{
        alert('You Not Select Any Bebt List!');
      }
    })

    $('#InputClient').change(function () {
        var client_id = $(this).val();
        var clientname = $("#InputClient option:selected").text();
        var owner = $("#InputClient option:selected").data('owner');
        var account = $("#InputClient option:selected").data('account');

        //alert(clientname)
        var url = `/debit/getdebitlistbyclient/${client_id}`;
        $.get(url,function (response) {
          console.log(response)
          $("#notiid").val(response.rejectnoti);
          if (response.expenses.length > 0 || response.incomes.length > 0 || response.rejects.length > 0 || response.carryfees.length > 0) {
            $('.search_btn').removeClass('d-none');
            $('.account').removeClass('d-none');
            $('.owner').removeClass('d-none');
            $('.account').html(`<p class="mt-5">Bank Account:  <strong>${account}</strong></p>`)
            $('.owner').html(`<p class="mt-5">Owner: <strong>${owner}</strong></p>`)
            $('#client_id').val(client_id)
          }else{
            $('.search_btn').addClass('d-none');
            $('.account').addClass('d-none');
            $('.owner').addClass('d-none');
          }
          var header = `<h4>ပေးရန် => ${clientname}:</h4>`;
          $('#topay').html(header);

          var footer = `<h4>ရရန် => ${clientname}:</h4>`;
          $('#toget').html(footer);

          let i = 1;
          var html = "";
          let total = 0;
          for(let row of response.expenses){
            let allpaid_delivery_fees = 0
            let unpaid_total_item_price = 0
            let prepaid_amount = 0

            for(let item of row.items){
              if (item.paystatus==2) {
                allpaid_delivery_fees += Number(item.delivery_fees)
              }else{
                unpaid_total_item_price += Number(item.deposit)
              }
            }

            if (row.expense != null && row.expense.status == 1) {
              prepaid_amount = Number(row.expense.amount)
            }

            html +=`<tr>
                    <td>
                      <div class="animated-checkbox">
                        <label class="mb-0">
                          <input type="checkbox" name="expenses[]" value="${row.id}" data-amount="${unpaid_total_item_price-prepaid_amount}"><span class="label-text"> </span>
                        </label>
                      </div>
                    </td>`
                    
            html+=`<td>${formatDate(row.created_at)}</td>`
                  
            html+=`<td> ${row.items.length}</td>
                    <td> ${thousands_separators(unpaid_total_item_price)} </td>
                    <td> ${thousands_separators(prepaid_amount)} </td>
                   <td>${thousands_separators(unpaid_total_item_price-prepaid_amount)} Ks</td>
                  </tr>`;
                  total += Number(unpaid_total_item_price-prepaid_amount);
          }
          html +=`<tr>
                    <td colspan="5">Total: </td>
                    <td>${thousands_separators(total)} Ks</td>
                  </tr>`;

          let j=1;
          var html2="";
          let total2=totalreject=totalincome=totalcarryfees=0;
          for(let row of response.rejects){
            // console.log(row)
            let delivery_fees = bus_gate_other = 0;

            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="rejects[]" value="${row.id}" data-amount="${row.item.deposit + delivery_fees}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.item.receiver_name}`; 
            if(row.status_code == '003')
                  html2 +=` <span class="badge badge-danger">reject</span>`;
          
            html2 +=`</td>
                      <td>${formatDate(row.item.created_at)}</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(row.item.deposit)}</td>
                      <td>${thousands_separators(bus_gate_other)}</td>
                      <td>${thousands_separators(row.item.deposit + delivery_fees)} Ks</td>
                  </tr>`;
                  totalreject += Number(row.item.deposit) + Number(delivery_fees);
          }

          for(let row of response.incomes){
            let delivery_fees=deposit=bus_gate_other=0;
            // if(row.payment_type_id == 4){
            //   delivery_fees = Number(row.way.item.delivery_fees);
            //   deposit = Number(row.way.item.deposit);
            // }else if(row.payment_type_id == 5){
            //   deposit = Number(row.way.item.deposit);
            // }else if(row.payment_type_id == 6){
            //   delivery_fees = Number(row.way.item.delivery_fees);
            // }

            if (row.paystatus ==2) {
              delivery_fees = Number(row.delivery_fees);
            }

            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="incomes[]" value="${row.id}" data-amount="${delivery_fees+deposit}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.receiver_name} - ${row.township.name}`;

            // if(row.payment_type_id == 4){
            //   html2 +=` <span class="badge badge-info">All Paid</span>`;
            // }else if(row.payment_type_id == 5){
            //   html2 +=` <span class="badge badge-info">Only Deposit</span>`;
            // }else if(row.payment_type_id == 6){
            //   html2 +=` <span class="badge badge-info">Only Deli</span>`;
            // }

            if (row.paystatus == 2) {
              html2 += ` <span class="badge badge-info">All Paid</span>`;
            }

            html2 +=`</td>
                      <td>${formatDate(row.created_at)}</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(deposit)}</td>
                      <td>${thousands_separators(bus_gate_other)}</td>
                      <td>${thousands_separators(delivery_fees+deposit)} Ks</td>
                    </tr>`;
                  totalincome += Number(delivery_fees + deposit);
          }

          for(let row of response.carryfees){
            // console.log(row)
            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="carryfees[]" value="${row.id}" data-amount="${row.amount}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.item.receiver_name} - ${row.item.township.name} <span class="badge badge-info">carryfees</span></td>
                      <td>${formatDate(row.created_at)}</td>
                      <td>${0}</td>
                      <td>${0}</td>
                      <td>${thousands_separators(row.amount)}</td>
                      <td>${thousands_separators(row.amount)} Ks</td>
                  </tr>`;
                  totalcarryfees += Number(row.amount);
          }

          total2  = Number(totalreject)+Number(totalincome)+Number(totalcarryfees);

          html2 +=`<tr>
                    <td colspan="6">Total: </td>
                    <td>${thousands_separators(total2)} Ks</td>
                  </tr>`;

          $('#debits').show();
          $('#debit_list').html(html);
          $('#reject_list').html(html2);
        })
      })

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
