@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Schedules By Clients</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('cities.index')}}">Schedules</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Pickup List</h3>
          <a href="{{route('schedules.create')}}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>

          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#schedules">Schedules</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending">Pending</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="schedules">
                <div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Pickup Date</th>
                        <th>Remark</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Client One</td>
                        <td>25-10-2020</td>
                        <td>This is a remark by clients</td>
                        <td>
                          <a href="#" class="btn btn-primary assign">Assign</a>
                          <a href="#" class="btn btn-warning">Edit</a>
                          <a href="#" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="pending">
                <div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Pickup Date</th>
                        <th>Remark</th>
                        <th>Delivery Man</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Client One</td>
                        <td>25-10-2020</td>
                        <td>This is a remark by clients</td>
                        <td>Mg Mg</td>
                        <td>
                          <a href="{{route('items.collect',1)}}" class="btn btn-primary">Collect</a>
                          <a href="#" class="btn btn-info">Pending</a>
                          <a href="#" class="btn btn-warning">Edit</a>
                          <a href="#" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
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
          <select class="form-control" name="delivery_man">
            <optgroup label="Choose Delivery Man">
              <option value="1">Mg Mg</option>
              <option value="2">Ba Kyaw</option>
            </optgroup>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Assign</button>
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
      })
    })
  </script>
@endsection

