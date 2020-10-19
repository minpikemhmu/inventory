@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Staff</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('staff.index')}}">Staff</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Staff List</h3>
          <a href="{{route('staff.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Address</th>
                <th>Designation</th>
                <th>Joined Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @php $i=1; @endphp
              @foreach($staff as $row)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user->name}}</td>
                <td>{{$row->phone_no}}</td>
                <td>{{$row->address}}</td>
                <td>{{$row->designation}}</td>
                <td>{{$row->joined_date}}</td>
                <td>
                  <a href="{{route('staff.show',$row->id)}}" class="btn btn-primary">Detail</a>
                  <a href="{{route('staff.edit',$row->id)}}" class="btn btn-warning">Edit</a>
                  <form action="{{ route('staff.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </main>
@endsection 