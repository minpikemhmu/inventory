@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Profile</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('profiles.edit',$user->id)}}">Profile</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Can Update Profile!</h3>
          <form action="{{route('profiles.update',$user->id)}}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
              <label for="InputName">Name:</label>
              <input class="form-control" id="InputName" type="text" placeholder="Enter name" name="name" value="{{$user->name}}">
               <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>

            <div class="form-group">
              <label for="InputEmail">Email:</label>
              <input class="form-control" id="InputEmail" type="email" placeholder="Enter email" name="email" value="{{$user->email}}">
               <div class="form-control-feedback text-danger"> {{$errors->first('email') }} </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">Update</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 