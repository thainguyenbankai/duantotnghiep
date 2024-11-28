<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <!-- Light Bootstrap Table core CSS -->
    <link href="{{ asset('assets/css/light-bootstrap-dashboard.css?v=1.4.0') }}" rel="stylesheet" />
    <!-- CSS for Demo Purpose, don't include it in your project -->
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets/css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    Creative Tim
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="{{ route('admin.index') }}">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="pe-7s-folder"></i>
                        <p>Danh mục</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}">
                        <i class="pe-7s-note2"></i>
                        <p>Sản phẩm</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="pe-7s-cart"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.brands.index') }}">
                        <i class="pe-7s-rocket"></i>
                        <p>Thương hiệu</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews.index') }}">
                        <i class="pe-7s-comment"></i>
                        <p>Đánh giá</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <p class="hidden-lg hidden-md">Thông báo</p>
                                <b class="caret hidden-lg hidden-md"></b>
                            </a>
                           
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <p>Dropdown
                                    <b class="caret"></b>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>  Create by website <3
                </p>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/chartist.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>
<script src="{{ asset('assets/js/light-bootstrap-dashboard.js?v=1.4.0') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        demo.initChartist();
        $.notify({
            icon: 'pe-7s-gift',
            message: " <b>{{ session('success') }}</b> "
        },{
            type: 'success',
            timer: 1000
        });
    });
</script>

</body>
</html>
