<!DOCTYPE html>
<html>
<head>
    @yield('css')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
       <h1>Networking Requests</h1>
    </div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
               <li class="active h4" style="margin-left:10px"><a href="{{ Request::root()}}"><i class="fa fa-home"></i>Home</a></li>
          </ul>
  </div>
  </div>
</nav>
    <div class="container-fluid">
    <div style="margin-top: 80px"></div>
        <div class="row">
            <div class="col-lg-12">

                @yield('content')
            </div>
    </div>

</div>
@yield('footer')

@yield('js')

</body>

</html>