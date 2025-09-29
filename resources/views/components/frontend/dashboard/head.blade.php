<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TPro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Quick Sand font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Karla:ital,wght@0,200..800;1,200..800&family=Playwrite+DE+VA+Guides&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Quicksand:wght@300..700&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">
    {{-- Lato font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Karla:ital,wght@0,200..800;1,200..800&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playwrite+DE+VA+Guides&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Quicksand:wght@300..700&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">
    {{-- inter font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Karla:ital,wght@0,200..800;1,200..800&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playwrite+DE+VA+Guides&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Quicksand:wght@300..700&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">

    {{-- menu css --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/plugins/menu.css')}}">

    {{-- content styles --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/plugins/content-styles.css')}}">

    {{-- normalize --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/normalize.css')}}">

    {{-- boostrap --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/bootstrap.min.css')}}">

    {{-- uicons --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/plugins/uicons-regular-straight.css')}}">

    {{-- animate --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/plugins/animate.min.css')}}">

    {{-- slick --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/plugins/slick.css')}}">

    {{-- core --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/core.css')}}">
    {{-- style --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/style.css')}}">

    {{-- custom --}}
    <link media="all" type="text/css" rel="stylesheet"
        href="{{asset('frontend/css/custom.css')}}">

    {{-- swipper plugin --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{ $slot }}

</head>
