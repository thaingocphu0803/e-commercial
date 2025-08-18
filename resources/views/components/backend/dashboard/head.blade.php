<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>TPro</title>

    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('backend/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
    {{ $slot }}

</head>
