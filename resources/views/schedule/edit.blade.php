@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Schedules")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Schedule Edit Form</h3>
          
          <form action="{{route('schedules.update',$schedule->id)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="oldfile" value="{{$schedule->file}}">
            <div class="form-group">
              <label for="InputDate">{{ __("Date")}}:</label>
              <input class="form-control" id="InputDate" type="date" name="date" value="{{$schedule->pickup_date}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('date') }} </div>
            </div>

            <div class="form-group">
              <label for="InputRemark">{{ __("Remark")}}:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark" >{{$schedule->remark}}</textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
            </div>

            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ __("New file")}}</a>
                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ __("Old file")}}</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div class="form-group">
              <label for="file">{{ __("File")}}:</label>
              <input type="file"  id="file" name="file">
            </div>
              </div>
              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <img src="{{asset($schedule->file)}}" width="300" height="300">
              </div>
            </div>
            
            <div class="form-group">
              <label for="quantity">{{ __("Quantity")}}:</label>
              <input type="number"  id="quantity" class="form-control" name="quantity" value="{{$schedule->quantity}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('quantity') }} </div>
            </div>

             <div class="form-group">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount" value="{{$schedule->amount}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">{{ __("Save")}}</button>
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