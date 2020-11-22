<!DOCTYPE html>
<html lang="en">
  <head>
    {{-- <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular."> --}}
    <title>Better Ways</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('assets/images/logo.jpg')}}" rel="shortcut icon"/>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.html">BetterWays</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        {{-- <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li> --}}
        <!--Notification Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">You have 4 new notifications.</li>
            <div class="app-notification__content">
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Lisa sent you a mail</p>
                    <p class="app-notification__meta">2 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Mail server not working</p>
                    <p class="app-notification__meta">5 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Transaction complete</p>
                    <p class="app-notification__meta">2 days ago</p>
                  </div></a></li>
              <div class="app-notification__content">
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Lisa sent you a mail</p>
                      <p class="app-notification__meta">2 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Mail server not working</p>
                      <p class="app-notification__meta">5 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Transaction complete</p>
                      <p class="app-notification__meta">2 days ago</p>
                    </div></a></li>
              </div>
            </div>
            <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
          </ul>
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            {{-- <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li> --}}
            <li><a class="dropdown-item" href="{{route('profiles.edit',Auth::user()->id)}}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}" 
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{Auth::user()->name}}</p>
          <p class="app-sidebar__user-designation">{{Auth::user()->getRoleNames()[0]}}</p>
        </div>
      </div>
      <ul class="app-menu">
        <!-- For Admin -->
        @role('admin')
        <li><a class="app-menu__item {{ Request::is('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview {{ Request::is('settings/*') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog" aria-hidden="true"></i><span class="app-menu__label">Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ Request::is('settings/cities*') ? 'active' : '' }}" href="{{route('cities.index')}}"><i class="icon fa fa-circle-o"></i> Cities</a></li>
            <li><a class="treeview-item {{ Request::is('settings/townships*') ? 'active' : '' }}" href="{{route('townships.index')}}"><i class="icon fa fa-circle-o"></i> Townships</a></li>
            <li><a class="treeview-item {{ Request::is('settings/statuses*') ? 'active' : '' }}" href="{{route('statuses.index')}}"><i class="icon fa fa-circle-o"></i> Delivery Status Codes</a></li>
            <li><a class="treeview-item {{ Request::is('settings/expense_types*') ? 'active' : '' }}" href="{{route('expense_types.index')}}"><i class="icon fa fa-circle-o"></i> Expense Types</a></li>
            <li><a class="treeview-item {{ Request::is('settings/payment_types*') ? 'active' : '' }}" href="{{route('payment_types.index')}}"><i class="icon fa fa-circle-o"></i> Payment Types</a></li>
            <li><a class="treeview-item {{ Request::is('settings/banks*') ? 'active' : '' }}" href="{{route('banks.index')}}"><i class="icon fa fa-circle-o"></i> Banks</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item {{ Request::is('success_list') ? 'active' : '' }}" href="{{route('success_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Success Ways</span></a></li>
        <li><a class="app-menu__item {{ Request::is('reject_list') ? 'active' : '' }}" href="{{route('reject_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Reject Ways</span><span class="badge badge-danger rejectcount"></span></a></li>
        {{-- <li><a class="app-menu__item {{ Request::is('return_list') ? 'active' : '' }}" href="{{route('return_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Return List</span></a></li> --}}
        <li><a class="app-menu__item {{ Request::is('delay_list') ? 'active' : '' }}" href="{{route('delay_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Delay List</span><span class="badge badge-danger delaycount"></span></a></li>
        <li><a class="app-menu__item {{ Request::is('statements') ? 'active' : '' }}" href="{{route('statements')}}"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Financial Statement</span></a></li>
        <li><a class="app-menu__item {{ Request::is('debt_list') ? 'active' : '' }}" href="{{route('debt_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Debit List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('staff*') ? 'active' : '' }}" href="{{route('staff.index')}}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Staff</span></a></li>
        @endrole

        <!-- For Staff -->
        @role('staff')
        <li><a class="app-menu__item {{ Request::is('schedules*') ? 'active' : '' }}" href="{{route('schedules.index')}}"><i class="app-menu__icon fa fa-calendar-check-o"></i><span class="app-menu__label">Pickup Schedules</span></a></li>
        <li><a class="app-menu__item {{ Request::is('items*') ? 'active' : '' }}" href="{{route('items.index')}}"><i class="app-menu__icon fa fa-archive"></i><span class="app-menu__label">Item List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('clients*') ? 'active' : '' }}" href="{{route('clients.index')}}"><i class="app-menu__icon fa fa-user-circle"></i><span class="app-menu__label">Client List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('delivery_men*') ? 'active' : '' }}" href="{{route('delivery_men.index')}}"><i class="app-menu__icon fa fa-user-circle-o"></i><span class="app-menu__label">Delivery Men</span></a></li>
        <li><a class="app-menu__item {{ Request::is('reject_list') ? 'active' : '' }}" href="{{route('reject_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label ">Reject Ways</span><span class="badge badge-danger rejectcount"></span></a></li>
        <li><a class="app-menu__item {{ Request::is('delay_list') ? 'active' : '' }}" href="{{route('delay_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Delay List</span><span class="badge badge-danger delaycount"></span></a></li>
        {{-- <li><a class="app-menu__item {{ Request::is('return_list') ? 'active' : '' }}" href="{{route('return_list')}}"><i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i><span class="app-menu__label">Return List</span></a></li> --}}
        <li><a class="app-menu__item {{ Request::is('debt_list') ? 'active' : '' }}" href="{{route('debt_list')}}"><i class="app-menu__icon fa fa-list-alt"></i><span class="app-menu__label">Debit List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('incomes*') ? 'active' : '' }}" href="{{route('incomes')}}"><i class="app-menu__icon fa fa-files-o"></i><span class="app-menu__label">Income</span></a></li>
        <li><a class="app-menu__item {{ Request::is('expenses*') ? 'active' : '' }}" href="{{route('expenses.index')}}"><i class="app-menu__icon fa fa-files-o"></i><span class="app-menu__label">Expense</span></a></li>
        @endrole

        <!-- For Delivery Men -->
        @role('delivery_man')
        <li><a class="app-menu__item {{ Request::is('pickups*') ? 'active' : '' }}" href="{{route('pickups')}}"><i class="app-menu__icon fa fa-get-pocket"></i><span class="app-menu__label">Pickup List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('ways*') ? 'active' : '' }}" href="{{route('ways')}}"><i class="app-menu__icon fa fa-hourglass-end"></i><span class="app-menu__label">Way List</span></a></li>
        @endrole

        <!-- For Client -->
        @role('client')
        <li><a class="app-menu__item {{ Request::is('schedules*') ? 'active' : '' }}" href="{{route('schedules.index')}}"><i class="app-menu__icon fa fa-calendar-check-o"></i><span class="app-menu__label">Pickup Appointments</span></a></li>
        <li><a class="app-menu__item {{ Request::is('cancel*') ? 'active' : '' }}" href="{{route('cancel.index')}}"><i class="app-menu__icon fa fa-calendar-check-o"></i><span class="app-menu__label">Cancel List</span></a></li>
        <li><a class="app-menu__item {{ Request::is('debt_list') ? 'active' : '' }}" href="{{route('debt_list')}}"><i class="app-menu__icon fa fa-list-alt"></i><span class="app-menu__label">Debit List</span></a></li>
        @endrole

      </ul>
    </aside>
    
    @yield('content')
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
  <script src="{{asset('datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('datatables/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('demo/datatables-demo.js')}}"></script>
  <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
  <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->
    
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
      }


      $(document).ready(function(){
        showNoti();
        delayNoti();

    function delayNoti(){
      $.get("/delaycount",function(res){
        console.log(res);
       $(".delaycount").html(res);

      })
    }

    function showNoti(){
      $.get("/rejectnoti",function(res){
        //console.log(res);
        var count=res.length;
        console.log(count);
        if(count>0){
          $(".rejectcount").html(count);
        }else{
          $(".rejectcount").html(0);
        }

      })
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('12ebc307a9a06080ceea', {
      cluster: 'mt1'
    });


    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      //alert(JSON.stringify(data));
      delayNoti()
      showNoti();

    });
  
      })
    </script>
    @yield('script')
  </body>
</html>