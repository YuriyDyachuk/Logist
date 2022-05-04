<!DOCTYPE html>
<html lang="ru">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113244328-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113244328-2');
    </script>

    <meta charset="utf-8">
    <title>Inn Logist</title>
    <meta name="description" content="Страница не найдена">
    <meta name="viewport" content="width=device-width">
    {{--<meta property="og:image" content="images/landings/img/dest/preview.jpg">--}}
    {{--<link rel="stylesheet" href="http://innlogist/images/landings/css/styles.min.css">--}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="images/png" sizes="32x32" href="http://innlogist/images/landings/favicon-32x32.png">
    <link rel="icon" type="images/png" sizes="16x16" href="http://innlogist/images/landings/favicon-16x16.png">
    <link rel="manifest" href="images/landings/site.webmanifest">
    <link rel="mask-icon" href="images/landings/safari-pinned-tab.svg" color="#dc005e">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">

    @include('layouts.includes.head')

    <style>
        body {
            background-color: #fff!important;
        }
    </style>

</head>

<body class="front404">

<div class="container-fluid">
    <div class="col-md-3 col-6">
        <div class="logo">
            <a href="/">
                <svg>
                    <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#inn_logo"></use>
                </svg>
            </a>
        </div>
    </div>
</div>


@include('errors.includes.404')
</body>
</html>