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
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">Schedules</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Create Schedule Form</h3>
          
          <form action="{{route('schedules.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="InputDate">Date:</label>
              <input class="form-control" id="InputDate" type="date" name="date">
              <div class="form-control-feedback text-danger"> {{$errors->first('date') }} </div>
            </div>

            <div class="form-group">
              <label for="InputRemark">Remark:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark" ></textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
            </div>

            <div class="form-group">
              <input type="checkbox" class="mychangepsw" id="cpassw">
              <label for="cpassw">Do you upload file</label>
              
            </div>

            <div class="form-group myfile">
              <label for="file">file:</label>
              <input type="file"  id="file" name="file"></textarea>
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
    $(".myfile").hide();
    $(".mychangepsw").click(function(){
      if(this.checked){
    $(".myfile").show();
      }else{
      $(".myfile").hide();
      }
    })
  })
</script>
@endsection