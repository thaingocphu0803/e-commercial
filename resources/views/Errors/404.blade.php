<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{__('custom.tpro404')}}</title>

    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">

</head>
<style>
    .btn-back-prev{
        margin-top: 3em;
    }
</style>

<body class="gray-bg">

    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">{{ __('custom.pageNotFound') }}</h3>
        <button class="btn-back-prev btn btn-lg btn-primary">{{ __('custom.backPrev') }}</button>
    </div>

    <!-- Mainly scripts -->
 <script src="{{asset('backend/js/jquery-3.1.1.min.js')}}"></script>
 <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
<script>
    $(document).on('click', '.btn-back-prev', function(){
        window.history.back();
    })
</script>
</body>

</html>
