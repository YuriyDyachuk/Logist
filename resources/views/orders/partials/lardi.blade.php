@extends("layouts.app")

@section("content")


    <button id="click">sdsd</button>

    <iframe  id="iframeNode" src="https://lardi-trans.com/ru/accounts/login/?backurl=https%3A%2F%2Flardi-trans.com%2Fru%2Fservices_prices%2F" width="1000" height="1000" align="left">
    </iframe>


@endsection

@push('scripts')
    <script >
        let src = 'index';
        var iframe = $('#iframeNode');
        $(document).ready(function () {

            $('#click').click(function () {
                console.log(iframe)
                iframe.load('https://lardi-trans.com/ru/services_price');
            })
        });
    </script>
@endpush