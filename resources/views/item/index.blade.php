@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">Items</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item List</h3>
          <a href="#" class="btn btn-primary float-right wayassign">Way Assign</a>

          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#collect">On Collect</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#way">On Way</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="collect">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Codeno</th>
                        <th>Township</th>
                        <th>Receiver Info</th>
                        <th>Expired Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="item" value="{{1}}"><span class="label-text"> </span>
                            </label>
                          </div>
                        </td>
                        <td>001-0003</td>
                        <td>Mayangone</td>
                        <td>
                          Ma Mon <span class="badge badge-dark">0987654321</span>
                        </td>
                        <td>25-10-2020</td>
                        <td>7000</td>
                        <td>
                          <a href="#" class="btn btn-primary detail">Detail</a>
                          <a href="#" class="btn btn-warning">Edit</a>
                          <a href="#" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="way">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Codeno</th>
                        <th>Township</th>
                        <th>Delivery Man</th>
                        <th>Expired Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="item" value="{{1}}"><span class="label-text"> </span>
                            </label>
                          </div>
                        </td>
                        <td>001-0003</td>
                        <td>Mayangone</td>
                        <td>
                          Ba Kyaw
                        </td>
                        <td>25-10-2020</td>
                        <td>7000</td>
                        <td>
                          <a href="#" class="btn btn-primary">Assigned</a>
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

  {{-- Ways Assign modal --}}
  <div class="modal fade" id="wayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
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

  {{-- Item Detail modal --}}
  <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">001-003</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Receiver Name:</strong> Ma Mon</p>
          <p><strong>Receiver Phone No:</strong> 09987654321</p>
          <p><strong>Receiver Address:</strong> No(3), Than Street, Hlaing, Yangon.</p>
          <p><strong>Remark:</strong> <span class="text-danger">Don't press over!!!!</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      $('.wayassign').click(function () {
        $('#wayAssignModal').modal('show');
      })

      $('.detail').click(function () {
        $('#itemDetailModal').modal('show');
      })
    })
  </script>
@endsection