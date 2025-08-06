<!DOCTYPE html>
<html>

<x-frontend.dashboard.header >
    {{ $heading  ?? ''}}
</x-frontend.dashboard.header>

@php
    // dd(config('cloudinary.cloud_name'));
@endphp
<body>
    <div id="wrapper">
        {{-- <x-frontend.dashboard.nav /> --}}

        <div id="page-wrapper" class="gray-bg">
            {{-- <x-frontend.dashboard.sidebar /> --}}

            {{-- start body --}}
            {{ $slot }}
            {{-- end body  --}}
            <x-frontend.dashboard.footer />
        </div>
    </div>

    <x-frontend.dashboard.script >
        {{ $script ?? '' }}
    </x-frontend.dashboard.script>
</body>

<script>
    const lang = "{{ app()->getLocale() }}";
    const cloudName = "{{config('cloudinary.cloud_name')}}";
    const uploadPreset = "{{config('cloudinary.upload_preset')}}";
</script>

</html>
