<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- /@vite('resources/css/app.css') --}}

    <title>{{ __('custom.tproAdmin') }}</title>

    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">TPro</h1>

            </div>
            <h3>{{ __('custom.welcomeTPro') }}</h3>

            <form class="m-t" role="form" action="{{ route('auth.login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="{{ __('custom.email') }}" value="{{old('email')}}">
                    @error('email')
                        <div class="error-message">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('custom.password') }}">
                    @error('password')
                        <div class="error-message">* {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">{{ __('custom.login') }}</button>

                <a href="#"><small>{{ __('custom.forgotPass') }}</small></a>
            </form>
            <p class="m-t"> <small>{{__('custom.copyrightBy', ['attribute' => 'TPro']);}}</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('backend/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
</body>

</html>
