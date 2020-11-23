@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Schedules</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">Schedules</a></li>
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
          <h3 class="tile-title d-inline-block">Pickup List</h3>
          <a href="{{route('schedules.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>


          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link @role('client'){{'active'}}@endrole" data-toggle="tab" href="#schedules">Schedules</a></li>
              <li class="nav-item"><a class="nav-link @role('staff'){{'active'}}@endrole" data-toggle="tab" href="#assigned">Assigned</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade @role('client'){{'active show'}}@endrole" id="schedules">
                <div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        @role('staff')<th>Client Name</th>@endrole
                        <th>Pickup Date</th>
                        <th>Remark</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @foreach($schedules as $row)
                      <tr>
                        <td>{{$i++}}</td>
                        @role('staff')
                          <td class="text-danger">{{$row->client->user->name}}</td>
                        @endrole
                        <td>{{$row->pickup_date}}</td>
                        <td>{{$row->remark}}</td>
                        <td>{{$row->quantity}}</td>
                        <td>
                          @role('staff')
                            <a href="#" class="btn btn-primary assign" data-id="{{$row->id}}">Assign</a>
                            <a href="#" class="btn btn-info showfile" data-file="{{$row->file}}">show file</a>
                          @endrole
                          @role('client')
                            @if($row->status==0)
                              <a href="#" class="btn btn-primary addfile" data-id="{{$row->id}}" data-file="{{$row->file}}">Add file for cpmplete</a>
                            @else
                              <a href="#" class="btn btn-info">completed</a>
                            @endif
                            <a href="{{route('schedules.edit',$row->id)}}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('schedules.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          @endrole
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade @role('staff'){{'active show'}}@endrole" id="assigned">
                <div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        @role('staff')<th>Client Name</th>@endrole
                        <th>Pickup Date</th>
                        <th>Remark</th>
                        <th>Delivery Man</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @foreach($pickups as $row)
                      <tr>
                        <td>{{$i++}}</td>
                        @role('staff')<td class="text-danger">{{$row->schedule->client->user->name}}</td>@endrole
                        <td>{{$row->schedule->pickup_date}}</td>
                        <td>{{$row->schedule->remark}}</td>
                        <td class="text-danger">{{$row->delivery_man->user->name}}</td>
                        <td>{{$row->schedule->quantity}}</td>
                        <td>
                          @if($row->status==1 && $row->schedule->quantity > count($row->items))
                            @role('staff')
                              <a href="{{route('items.collect',['cid'=>$row->schedule->client->id,'pid'=>$row->id])}}" class="btn btn-primary">Collect</a>
                            @endrole
                            @role('client')
                              <button type="button" class="btn btn-info">Brought</button>
                            @endrole
                          @elseif($row->status == 1 && $row->schedule->quantity == count(($row->items)))
                            <button type="button" class="btn btn-info">completed</button>
                          @elseif($row->status==2)
                           <a href="{{route('checkitem',$row->id)}}" class="btn btn-danger">fail</a>
                          @else
                            <button type="button" class="btn btn-danger">pending</button>
                          @endif

                          {{-- <a href="#" class="btn btn-warning">Edit</a>
                          <a href="#" class="btn btn-danger">Delete</a> --}}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Assign modal --}}
  <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Assign Delivery Man</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('schedules.storeandassign')}}" method="POST" enctype="multipart/form-data">
            @csrf
          <input type="hidden" name="assignid" id="assignid" value="">
          <select class="form-control" name="deliveryman">
            <optgroup label="Choose Delivery Man">
              <option>choose delivery man</option>
              @foreach($deliverymen as $row)
              <option value="{{$row->id}}">{{$row->user->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Assign</button>
        </form>
        </div>
      </div>
    </div>
  </div>

{{-- addfile modal --}}
 <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('uploadfile')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="addid" id="addid" value="">
            <input type="hidden" name="oldfile" id="oldfile">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New file</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Old file</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="form-group">
                  <input type="file"  id="addfile" name="addfile">
                 </div>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <img src="" class="myoldfile img-fluid">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">save</button>
        </form>
        </div>
      </div>
    </div>
  </div>

{{-- show file modal --}}
<div class="modal fade" id="filedisplay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="img-fluid stafffile" width="100%" height="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      $('.assign').click(function () {
        $('#assignModal').modal('show');
        var id=$(this).data(id);
        //console.log(id);
      $("#assignid").val(id.id);
      })

      $('.addfile').click(function () {
        $('#addModal').modal('show');
        var id=$(this).data(id);
        var file=$(this).data(file);
        console.log(file.file);
        //console.log(id.id);
        $("#addid").val(id.id);
        $("#oldfile").val(file.file);
        $(".myoldfile").attr("src",file.file)
      })

      $(".showfile").click(function(){
        $('#filedisplay').modal('show');
        var file=$(this).data("file");
        //console.log(file);
        $(".stafffile").attr("src",file);


      })

      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    })
  </script>
@endsection