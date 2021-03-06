@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i>{{ __(" Schedule")}}s</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @role('client')
            <h3 class="tile-title d-inline-block">Create Schedule Form</h3>
            <form method="post" action="{{route('schedules.store')}}" enctype="multipart/form-data">
            <input type="hidden" name="client" value="{{Auth::user()->client->id}}">
          @endrole
          @role('staff')
            <h3 class="tile-title d-inline-block">{{ __("Create Schedule and Assign")}}</h3>
            <form method="post" action="{{route('schedules.storeandassign')}}" enctype="multipart/form-data">
            <div class="form-group">
              <label for="InputClient">{{ __("Client")}}:</label>
              <select class="form-control" name="client" id="InputClient">
                <optgroup label="Choose Client">
                  @foreach($clients as $row)
                  <option value="{{$row->id}}">{{$row->clientname}} ({{$row->address}})</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
          @endrole
            @csrf
            <div class="form-group">
              <label for="txtDate">{{ __("Date")}}:</label>
              <input class="form-control" id="txtDate" type="date" name="date" required>
              <div class="form-control-feedback text-danger"> {{$errors->first('date') }} </div>
            </div>   

            <div class="form-group">
              <label for="InputRemark">{{ __("Remark")}}:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark" ></textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
            </div>

            <div class="form-group">
              <label for="file">{{ __("File")}}:</label> 
              <input type="file" id="file" name="file" class="form-control-file">
            </div>

            <div class="form-group">
              <input type="checkbox" id="know">
              <label for="know">{{ __("If you know quantity and amount")}}</label> 
            </div>

            <div class="form-group quantity">
              <label for="quantity">{{ __("Quantity")}}:</label>
              <input type="number"  id="quantity" class="form-control" name="quantity">
              <div class="form-control-feedback text-danger"> {{$errors->first('quantity') }} </div>
            </div>

            <div class="form-group amount">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>
            
            @role('staff')
            <div class="form-group">
              <label for="InputDeliveryMan">{{ __("Delivery Man")}}:</label>
              <select class="form-control" name="deliveryman" id="InputDeliveryMan">
                <optgroup label="Choose Delivery Man">
                 @foreach($deliverymen as $row)
                  <option value="{{$row->id}}">{{$row->deliveryname}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-sm btn-primary" type="submit">{{ __("Save And Assign")}}</button>
            </div>
            @endrole

            @role('client')
            <div class="form-group">
              <button class="btn btn-sm btn-primary" type="submit">{{ __("Save")}}</button>
            </div>
            @endrole
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 
@section('script')

<script type="text/javascript">
  $(document).ready(function(){

    $(".quantity").hide();
    $(".amount").hide();

    $("#know").click(function(){
      if(this.checked){
        $(".quantity").show();
        $(".amount").show();
      }else{
        $(".quantity").hide();
        $(".amount").hide();
      }
    })

    $(function(){
      var dtToday = new Date();
      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();

      if(month < 10)
          month = '0' + month.toString();
      if(day < 10)
          day = '0' + day.toString();

      var maxDate = day+ '-' +month+ '-' +year;
      $('#txtDate').attr('min', maxDate);
    });
    
  })
</script>
@endsection