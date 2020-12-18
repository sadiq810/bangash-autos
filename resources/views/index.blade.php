<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bangash Autos</title>
    <base/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/font-awesome/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Rubik:300,400,400i,500,500i,700,700i,900' rel='stylesheet' type='text/css'/>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frontend/image/favicon') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/image/favicon') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/image/favicon') }}/favicon-16x16.png">
    <script src="{{ asset('assets/frontend') }}/jquery/jquery-2.1.1.min.js"></script>
    <script>
        var BaseUrl = '{{ url('/') }}';
        var loader = null;
    </script>
</head>
<body class="ltr layout-2">
<div id="wrapper" class="wrapper-full banners-effect-7">
    <div id="app"></div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/vendor.js') }}" defer></script>
</body>
</html>
