<!DOCTYPE html>
<html>

<head>
    <title>AMS @hasSection('page-title')
            - @yield('page-title')
        @else
        @endif
    </title>
     <link href="{{ asset('assets/packages/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
    {{-- icon --}}
    <link rel="icon" href="{{ asset('assets/images/PUP.png') }}" type="image/x-icon">
    @yield('styles')
    @livewireStyles()
</head>

<body class="pup-bg">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-12">
                <div class="card bg-glass border-0 text-maroon text-center d-flex  border-maroon my-auto">
                    <div class="card-header bg-transparent border-bottom-0 pb-1">
                        <div class="row justify-content-center mb-2">
                            <img src="{{ asset('assets/images/PUP.png') }}" alt="PUP LOGO"
                                style="height: 140px; width:150px;">
                        </div>
                        <h1 class="text-center">Computer Laboratory AMS</h1>
                    </div>
                    @yield('contents')
                </div>
            </div>
        </div>
    </div>
     <script src="{{ asset('assets/packages/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @yield('scripts')
    @include('sweetalert::alert')
    @livewireScripts
</body>

</html>
