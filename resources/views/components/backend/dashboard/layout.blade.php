<!DOCTYPE html>
<html>

<x-backend.dashboard.header >
    {{ $heading  ?? ''}}
</x-backend.dashboard.header>

@php
    // dd(config('cloudinary.cloud_name'));
@endphp
<body>
    <div id="wrapper">
        <x-backend.dashboard.nav />

        <div id="page-wrapper" class="gray-bg">
            <x-backend.dashboard.sidebar />

            {{-- start body --}}
            {{ $slot }}
            {{-- end body  --}}
            <x-backend.dashboard.footer />
        </div>
    </div>

    <x-backend.dashboard.script >
        {{ $script ?? '' }}
    </x-backend.dashboard.script>
</body>

<script>
    const lang = "{{ app()->getLocale() }}";
    const cloudName = "{{config('cloudinary.cloud_name')}}";
    const uploadPreset = "{{config('cloudinary.upload_preset')}}";
</script>

</html>
