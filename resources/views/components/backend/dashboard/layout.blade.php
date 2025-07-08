<!DOCTYPE html>
<html>

<x-backend.dashboard.header >
    {{ $heading  ?? ''}}
</x-backend.dashboard.header>


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

</html>
