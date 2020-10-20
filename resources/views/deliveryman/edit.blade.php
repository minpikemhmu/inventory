@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Delivery Men</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('delivery_men.index')}}">Delivery Men</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Delivery Men Edit Form</h3>
          
          <form action="{{route('delivery_men.update',$deliveryMan->id)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="oldpassword" value="{{$deliveryMan->user->password}}">
           <div class="form-group">
              <label for="InputCityName">Name:</label>
              <input class="form-control" id="InputCityName" type="text" placeholder="Enter name" name="name" value="{{$deliveryMan->user->name}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email"value="{{$deliveryMan->user->email}}">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              <div class="form-control-feedback text-danger"> {{$errors->first('email') }} </div>
            </div>

            <div class="form-group">
              <label for="cpassw">Change Password</label>
              <input type="checkbox" class="mychangepsw" id="cpassw">
            </div>

            <div class="form-group psw">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter Password">
              <div class="form-control-feedback text-danger"> {{$errors->first('password') }} </div>
            </div>

            <div class="form-group cpsw">
              <label for="password-confirm">Confirm Password</label>
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
              
            </div>

            <div class="form-group">
              <label for="phone">Phone No:</label>
              <input class="form-control" id="phone" type="text" placeholder="Enter Phone No" name="phone" value="{{$deliveryMan->phone_no}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('phone') }} </div>
            </div>

            <div class="form-group">
              <label for="address">Address:</label>
              <input class="form-control" id="address" type="text" placeholder="Enter Address" name="address" value="{{$deliveryMan->address}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('address') }} </div>
            </div>

            <div class="form-group">
              <label for="township">Delivery Townships:</label>
              @php
              $v = $deliveryMan->townships;
              @endphp
              <select class="js-example-basic-multiple form-control" name="township[]" multiple="multiple" id="township">
                <option>Choose Delivery Township</option>
                @foreach($townships as $row)
                <option value="{{$row->id}}"  @foreach($v as $key=> $value)

                  @if($row->id==$value->pivot->township_id) {{"selected"}} @endif 
                  @endforeach>{{$row->name}}</option>
                @endforeach
                 
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('townships') }} </div>
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
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    $(".psw").hide();
    $(".cpsw").hide();
    $(".mychangepsw").click(function(){
      if(this.checked){
    $(".psw").show();
    $(".cpsw").show();
      }else{
      $(".psw").hide();
    $(".cpsw").hide();
      }
    })
  })
</script>
@endsection