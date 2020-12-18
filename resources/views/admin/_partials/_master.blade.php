<!DOCTYPE html>
<html lang="en">
@include('admin._partials.head')
<body class="fix-header card-no-border logo-center">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper">
        @include('admin._partials.header')
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            <footer class="footer">
                © 2019 Bangash Autos
            </footer>
        </div>
    </div>

    @include('admin._partials.footer-js')
    @yield('footer')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function toast(type = 'success', heading = 'Success', text = "") {
            $.toast({
                heading: heading,
                text: text,
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: type,
                hideAfter: 3000,
                stack: 6
            });
        }
    </script>
</body>
</html>
