<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EasyCommerce</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body style="background-color: #dce2e4">
    {{-- Menu --}}
    <x-menu />
    {{-- Content --}}
    <main id="app" class="container my-5">
        <div class="container">
            <x-alerts />
        </div>

        {{ $slot }}
    </main>
</body>

</html>
