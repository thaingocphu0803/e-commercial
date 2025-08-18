<!DOCTYPE html>
<html>
<x-frontend.dashboard.head>
    {{ $heading ?? '' }}
</x-frontend.dashboard.head>

@php
    // dd(config('cloudinary.cloud_name'));
@endphp

<body id="page-home" data-new-gr-c-s-check-loaded="14.1247.0" data-gr-ext-installed="" style="overflow: visible;">
    {{-- header --}}
    <x-frontend.dashboard.header :system="$system"/>

    {{-- start body --}}
    {{ $slot }}
    {{-- end body  --}}

    {{-- footer --}}
    <x-frontend.dashboard.footer :system="$system"/>

    {{-- script --}}
    <x-frontend.dashboard.script>
        {{ $script ?? '' }}
    </x-frontend.dashboard.script>
</body>

<script>
    const lang = "{{ app()->getLocale() }}";
    const cloudName = "{{ config('cloudinary.cloud_name') }}";
    const uploadPreset = "{{ config('cloudinary.upload_preset') }}";
</script>

</html>
