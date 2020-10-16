@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Financial Statements</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="bs-component">
            <ul class="nav nav-tabs nav-pills">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Income</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Expense</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profit">Profit</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="home">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Item Code</th>
                      <th>Delivery Men</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><span class="badge badge-primary">0001-0024</span></td>
                      <td>Kyaw Lwin</td>
                      <td>3,000</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td><span class="badge badge-primary">0001-0323</span></td>
                      <td>Min Pike</td>
                      <td>2,500</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td><span class="badge badge-primary">0031-0015</span></td>
                      <td>Kyaw Kyi</td>
                      <td>5,000</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td><span class="badge badge-primary">0031-0004</span></td>
                      <td>Hein Min</td>
                      <td>1,500</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="profile">
                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
              </div>
              <div class="tab-pane fade" id="profit">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 