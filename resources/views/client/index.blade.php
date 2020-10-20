@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Clients</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('clients.index')}}">Clients</a></li>
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
          <h3 class="tile-title d-inline-block">Clients List</h3>
          <a href="{{route('clients.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Address</th>
                <th>Contact_Person</th>
                <th>Township</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @php $i=1; @endphp
              @foreach($clients as $row)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user->name}}</td>
                <td>{{$row->phone_no}}</td>
                <td>{{$row->address}}</td>
                <td>{{$row->contact_person}}</td>
                <td>{{$row->township->name}}</td>
                <td>
                  <a href="{{route('clients.edit',$row->id)}}" class="btn btn-warning">Edit</a>
                  <form action="{{ route('clients.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

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
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    //alert("ok");
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
  })
  
</script>
@endsection