<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Echo | Dashboard</title>

    @include('includes.attributes')

    <link rel="icon" href="/favicon.svg">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-netral relative">
    @include('includes.header')
    <main class="p-4 min-h-[85vh]">
        @yield('content')
    </main>
    @include('includes.footer')
    @yield('scripts')
</body>

</html>
