<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="author" content="{{ config('app.author') }}">
    <meta name="keyword" content="{{ config('app.name') }}, {{ config('app.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    {{Html::style('assets/css/bootstrap.css')}}
            <!--external css-->
    {{Html::style('assets/font-awesome/css/font-awesome.css')}}
    {{Html::style('assets/js/gritter/css/jquery.gritter.css')}}

            <!-- Custom styles for this template -->
    {{Html::style('assets/css/style.css')}}
    {{Html::style('assets/css/style-responsive.css')}}

    @stack('css')

            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<section id="container" >

    <!--header start-->
    <header class="header black-bg">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="#" class="logo"><b> {{ config('app.description') }} </b></a>
        <!--logo end-->
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" href="{{route('get.logout')}}"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">

                <p class="centered"><a href="#"><img src="assets/img/kasir-p.png" class="img-circle" width="60"></a></p>
                <h5 class="centered">{{Auth::user()->nama}}</h5>
                <h6 class="centered">{{Auth::user()->status}}</h6>

                <li>
                    <a href="{{route('main')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{route('nasabah')}}"><i class="fa fa-users"></i><span>Nasabah</span></a>
                </li>
                <li>
                    <a href="{{route('transaksi')}}"><i class="fa fa-credit-card"></i><span>Transaksi</span></a>
                </li>
                <li>
                    <a href="{{route('koperasi')}}"><i class="fa fa-university"></i><span>Koperasi</span></a>
                </li>
                <li>
                    <a href="{{route('pegawai')}}"><i class="fa fa-user-md"></i><span>Pegawai</span></a>
                </li>
                <li>
                    <a href="{{route('laporan')}}"><i class="fa fa-file"></i><span>Laporan</span></a>
                </li>
                {{--
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-edit"></i>
                        <span>Edit</span>
                        <span class="pull-right">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="sub">
                        <li>
                            <a href="">
                                <i class="fa fa-plus"></i>
                                Title
                            </a>
                        </li>
                    </ul>
                </li>
                --}}
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    @yield('content')
            <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
        <div class="text-center">
            <strong>Copyright &copy; 2016 - {{config('app.description', 'BSM')}}.</strong> All rights reserved.
            <a href="#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
</section>
<div class="loading">
    <img src="assets/img/loading.gif">
</div>

<!-- js placed at the end of the document so the pages load faster -->
{{ Html::script('assets/js/jquery.js') }}
{{ Html::script('assets/js/bootstrap.min.js') }}
{{ Html::script('assets/js/jquery-ui-1.9.2.custom.min.js') }}
{{ Html::script('assets/js/jquery.ui.touch-punch.min.js') }}
{{ Html::script('assets/js/jquery.dcjqaccordion.2.7.js') }} {{-- class="include" --}}
{{ Html::script('assets/js/jquery.scrollTo.min.js') }}
{{ Html::script('assets/js/jquery.nicescroll.js') }}
{{ Html::script('assets/js/jquery.sparkline.js') }}


        <!--common script for all pages-->
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.6.0/socket.io.js') }}
{{ Html::script('assets/js/common-scripts.js') }}
{{ Html::script('assets/js/gritter/js/jquery.gritter.js') }}
{{ Html::script('assets/js/gritter-conf.js') }}
{{ Html::script('js/all-pages.js') }}
<script type="application/javascript">
    $(function(){
        var server = io('http://localhost:5656'), //------------> Port Server Redis
            jqxhr = $.ajax({
                url      : "{{route('notif')}}",
                type     : "GET",
                dataType : "json",
                async    : true,
                global   : false
            });
        var notif = $('#scroll-notif');
        jqxhr.done(function(data){
            notif.empty();
            console.log("-------------- jqXHR");
            console.log(data);
            $.each(data.notif.data, function(key, val){
                var div = '<div class="desc">'+
                        '<div class="thumb" style="margin: 20px 10px">'+
                        '<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>'+
                        '</div>'+
                        '<div class="details">'+
                        '<p>' +
                        '<span class="text-muted">'+val.waktu+'</span><br/>'+
                        '<span class="text-danger">'+val.nasabah+'</span><br/>'+
                        '<span class="text-warning">'+val.transaksi+'</span><br/>'+
                        '<span class="text-success">'+val.lembaga+'</span><br/>'+
                        '<span class="text-info">'+val.jumlah+'</span>'+
                        '</p>'+
                        '</div>'+
                        '</div>';
                notif.prepend(div);
            });
        });
        server.on("connect", function(){
            console.log("Connect");
            server.on('nasabah_transaksi', function(data){
                console.log("nasabah_transaksi");
                console.log(data);
                jqxhr = $.ajax({
                    url      : "{{route('notif')}}",
                    type     : "GET",
                    dataType : "json",
                    async    : true,
                    global   : false
                });

                jqxhr.done(function(data){
                    notif.empty();
                    console.log("-------------- jqXHR");
                    console.log(data);
                    $.each(data.notif.data, function(key, val){
                        var div = '<div class="desc">'+
                                '<div class="thumb" style="margin: 20px 10px">'+
                                '<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>'+
                                '</div>'+
                                '<div class="details">'+
                                '<p>' +
                                '<span class="text-muted">'+val.waktu+'</span><br/>'+
                                '<span class="text-danger">'+val.nasabah+'</span><br/>'+
                                '<span class="text-warning">'+val.transaksi+'</span><br/>'+
                                '<span class="text-success">'+val.lembaga+'</span><br/>'+
                                '<span class="text-info">'+val.jumlah+'</span>'+
                                '</p>'+
                                '</div>'+
                                '</div>';
                        notif.prepend(div);
                    });
                });
            });
        });

        server.on("disconnect", function(){
            console.log("Disconnect");
        });

    });
</script>
        <!--script for this page-->
@stack('js')

</body>
</html>
