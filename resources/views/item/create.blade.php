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
          
          <form method="" action="">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputCodeno">Codeno:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="001-003" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="InputReceiverName">Receiver Name:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name">
                </div>

                <div class="form-group">
                  <label for="InputReceiverPhoneNumber">Receiver Phone Number:</label>
                  <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno">
                </div>

                <div class="form-group">
                  <label for="InputReceiverAddress">Receiver Address:</label>
                  <textarea class="form-control" id="InputReceiverAddress" name="receiver_address"></textarea>
                </div>

                <div class="form-group">
                  <label for="InputReceiverTownship">Receiver Township:</label>
                  <select class="form-control" id="InputReceiverTownship" name="receiver_township">
                    <optgroup label="Choose Township">
                      <option value="1">Mayangone</option>
                    </optgroup>
                  </select>
                </div>

                <div class="form-group">
                  <label for="InputExpiredDate">Expired Date:</label>
                  <input class="form-control" id="InputExpiredDate" type="date" name="expired_date">
                </div>

                <div class="form-group">
                  <label for="InputDeposit">Deposit:</label>
                  <input class="form-control" id="InputDeposit" type="number" name="deposit" value="0">
                </div>

                <div class="form-group">
                  <label for="InputDeliveryFees">Delivery Fees:</label>
                  <input class="form-control" id="InputDeliveryFees" type="number" name="delivery_fees">
                </div>

                <div class="form-group">
                  <label for="InputAmount">Amount: (deposit+delivery fees+others)</label>
                  <input class="form-control" id="InputAmount" type="number" name="amount">
                </div>

                <div class="form-group">
                  <label for="InputRemark">Remark:</label>
                  <textarea class="form-control" id="InputRemark" name="remark"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <input type="hidden" name="client_id" value="{{$client->id}}">

                <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">Client Informations:</h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Name: {{$client->user->name}}</li>
                    <li class="list-group-item">Contact Person: {{$client->contact_person}}</li>
                    <li class="list-group-item">Phone Number: {{$client->phone_no}}</li>
                    <li class="list-group-item">Township: {{$client->township->name}}</li>
                  </ul>
                </div>

                <img src="{{asset($schedule->file)}}" class="img-fluid">
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