@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Expenses</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('expenses.index')}}">Expenses</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Expense Create Form</h3>
          
          <form action="{{route('expenses.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="description">description:</label>
              <input class="form-control" id="description" name="description"type="text" placeholder="Enter description">
              <div class="form-control-feedback text-danger"> {{$errors->first('description') }} </div>
            </div>

            <div class="form-group">
              <label for="amount">Amount:</label>
              <input class="form-control" id="amount" name="amount" type="number" placeholder="Enter amount">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>

            <div class="form-group">
              <label for="expensetype">Expense Types</label>
              <select class="form-control" id="expensetype" name="expensetype">
                <option>Choose Expense Type</option>
                @foreach($expensetypes as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('expensetype') }} </div>
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