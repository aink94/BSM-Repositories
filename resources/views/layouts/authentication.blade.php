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
    {{ Html::style('assets/css/bootstrap.css') }}
            <!--external css-->
    {{ Html::style('assets/font-awesome/css/font-awesome.css') }}

            <!-- Custom styles for this template -->
    {{ Html::style('assets/css/style.css') }}
    {{ Html::style('assets/css/style-responsive.css') }}
    {{Html::style('assets/js/gritter/css/jquery.gritter.css')}}

    @stack('css')

            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

@yield('content')

        <!-- js placed at the end of the document so the pages load faster -->
{{ Html::script('assets/js/jquery.js') }}
{{ Html::script('assets/js/bootstrap.min.js') }}

        <!--BACKSTRETCH-->
<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
{{ Html::script('assets/js/jquery.backstretch.min.js')}}

        <!--common script for all pages-->
{{ Html::script('assets/js/gritter/js/jquery.gritter.js') }}
{{ Html::script('assets/js/gritter-conf.js') }}
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.6.0/socket.io.js') }}
{{ Html::script('js/all-pages.js') }}

<script>
    $.backstretch("assets/img/login-bg.jpg", {speed: 500});
</script>

@stack('js')

</body>
</html>
