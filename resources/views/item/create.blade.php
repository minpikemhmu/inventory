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
          <h3 class="tile-title d-inline-block">Item Create Form</h3>
          
          <form method="" action="">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputCodeno">Codeno:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="001-003" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="InputClient">Client:</label>
                  <select class="form-control" id="InputClient" name="client">
                    <optgroup label="Choose Client">
                      <option value="1">Ma San</option>
                    </optgroup>
                  </select>
                </div>

                <div class="form-group">
                  <label for="InputTownship">Township:</label>
                  <select class="form-control" id="InputTownship" name="township">
                    <optgroup label="Choose Township">
                      <option value="1">Mayangone</option>
                    </optgroup>
                  </select>
                </div>                

                <div class="form-group">
                  <label for="InputReceiverName">Receiver Name:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name">
                </div>

              </div>
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