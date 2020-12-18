<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="https://img.icons8.com/cotton/64/000000/bookmark-ribbon.png">
    <title>Bangash Autos Back Office</title>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors/blue.css') }}" id="theme" rel="stylesheet">

    <!-- chartist CSS -->
    <link href="{{ asset('assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{{ asset('assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/dropzone-master/dist/dropzone.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/moment/moment.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .preloader {
            background: #201e1e !important;
            opacity: 0.5;
        }

        .modal-body {
            margin-top: 10px;
        }

        td.details-control {
            background: url('{{ url('/') }}/assets/images/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ url('/') }}/assets/images/details_close.png') no-repeat center center;
        }
    </style>
    <script>
        var BaseUrl = '{{ url('/') }}';
    </script>
</head>
