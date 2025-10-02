@props([
    'system' => [],
    'seo' => [],
])
<head>

    {{-- @dd($seo); --}}

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="{{$system['homepage_company']}}">
    <meta name="copyright" content="{{$system['homepage_copyright']}}">
    <meta http-equiv="refresh" content="1800">
    <link rel="icon" href="{{base64_decode($system['homepage_favicon'])}}" type="image/png" sizes="30x30">

    {{-- GOOGLE --}}
    <title>{{$seo['meta_title'] ?? $system['seo_title_seo']}}</title>
    <meta name="description" content="{{$seo['meta_description'] ?? $system['seo_desciption_seo']}}">
    <meta name="keyword" content="{{$system['seo_keyword_seo']}}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? config('app.url')}}">
    <meta property="og:locale" content="vi_VN">
    {{-- FACEBOOK --}}
    <meta property="og:title" content="{{$seo['meta_description'] ?? $system['seo_title_seo']}}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{$seo['meta_image'] ?? $system['seo_image_seo']}}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? config('app.url')}}">
    <meta property="og:site_name" content="">
    <meta property="og:description" content="{{$seo['meta_description'] ?? $system['seo_desciption_seo']}}">
    <meta property="fb:admins" content="">
    <meta property="fb:app_id" content="">
    {{-- TWITTER --}}
    <meta property="twitter:card" content="sumary">
    <meta property="twitter:title" content="{{$seo['meta_description'] ?? $system['seo_title_seo']}}">
    <meta property="twitter:description" content="{{$seo['meta_description'] ?? $system['seo_desciption_seo']}}">
    <meta property="twitter:image" content="{{$seo['meta_image'] ?? $system['seo_image_seo']}}">

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
