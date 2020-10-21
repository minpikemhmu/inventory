@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Incomes</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('incomes')}}">Incomes</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Income Create Form</h3>
          
          <form action="{{route('incomes.store')}}" method="POST">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="InputDeliveryMan">Select Delivery Man:</label>
                <select class="form-control" id="InputDeliveryMan" name="deliveryman">
                  <optgroup label="Select Delivery Man">
                    <option value="1">Mg Mg</option>
                    <option value="2">Ba Kyaw</option>
                  </optgroup>
                </select>
              </div>
            </div>

            <label>Success Ways By Mg Mg:</label>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Codeno</th>
                    <th>Township</th>
                    <th>Delivery Man</th>
                    <th>Expired Date</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>001-0003</td>
                    <td>Mayangone</td>
                    <td>
                      Ba Kyaw
                    </td>
                    <td>25-10-2020</td>
                    <td>7,000</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td>12,000</td>
                  </tr>
                </tbody>
              </table>
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