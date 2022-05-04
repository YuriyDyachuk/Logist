<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.head')
</head>
<body style="height: 100%">
<section>
    <div class="container-fluid page-content" style="height: auto; min-height: 100%; position: relative">
        @include('layouts.includes.header-register')

        <div class="row">
            @yield('content')
        </div>

        @include('layouts.includes.footer')
    </div>
</section>

<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/phone_input/js/intlTelInput.js') }}"></script>

@stack('scripts')

</body>
</html>