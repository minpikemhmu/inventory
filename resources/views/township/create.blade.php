@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Townships</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('townships.index')}}">Townships</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Township Create Form</h3>
          
          <form action="{{route('townships.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="InputCityName">Name:</label>
              <input class="form-control" id="InputCityName" type="text" placeholder="Enter name" name="name">
               <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>

            <div class="form-group">
              <label for="delifee">Delivery Fees:</label>
              <input class="form-control" id="delifee" type="text" placeholder="Enter Delivery Fees" name="delifee">
               <div class="form-control-feedback text-danger"> {{$errors->first('delifee') }} </div>
            </div>

            <div class="form-group">
              <label for="city">City</label>
              <select class="form-control" id="city" name="city">
                <option>Choose City</option>
                @foreach($cities as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('city') }} </div>
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