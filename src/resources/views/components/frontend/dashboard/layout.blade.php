@props([
    'seo' => []
])

<!DOCTYPE html>
<html>
<x-frontend.dashboard.head :system="$system" :seo="$seo">
    {{ $heading ?? '' }}
</x-frontend.dashboard.head>


<body id="page-home" data-new-gr-c-s-check-loaded="14.1247.0" data-gr-ext-installed="" style="overflow: visible;">
    {{-- header --}}
    <x-frontend.dashboard.header :system="$system" />

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
    const appUrl = "{{  config('app.url') }}";
    const cloudName = "{{ config('cloudinary.cloud_name') }}";
    const uploadPreset = "{{ config('cloudinary.upload_preset') }}";
</script>

</html>
