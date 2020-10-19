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
          <h3 class="tile-title d-inline-block">Township List</h3>
          <a href="{{route('townships.create')}}" class="btn btn-primary float-right">Add New</a>
          <table class="table" id="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>City</th>
                <th>Delivery Fees</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @php $i=1; @endphp
               @foreach($townships as $row)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->city->name}}</td>
                <td>{{$row->delivery_fees}}</td>
                <td>
                  <a href="{{route('townships.edit',$row->id)}}" class="btn btn-warning">Edit</a>
                  <form action="{{ route('townships.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

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