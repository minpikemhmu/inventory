@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Ways</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('ways')}}">Ways</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Ways List (14-Oct-2020)</h3>
          <div class="float-right delivery_actions">
            <a href="#" class="btn btn-success btn-sm mx-2">Success</a>
            <a href="#" class="btn btn-warning btn-sm mx-2">Return</a>
            <a href="#" class="btn btn-danger btn-sm mx-2">Reject</a>
          </div>

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
                        <input type="checkbox" name="ways[]" value="{{1}}"><span class="label-text"> </span>
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
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

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
      // $('.delivery_actions').hide();

      $('.detail').click(function () {
        $('#itemDetailModal').modal('show');
      })
    })
  </script>
@endsection