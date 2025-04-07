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
    <div class="flex gap-4 px-4 h-[85vh] mt-4 overflow-y-auto">
        <nav class="w-1/6 flex flex-col gap-2 p-4 bg-light rounded-md">
            <h3 class="font-bold text-xl">Main Menu</h3>
            <a class="underline" href="{{ route('dashboard.item') }}">Gudang</a>
            <a class="underline" href="{{ route('dashboard.item-type') }}">Tipe Item</a>
        </nav>
        <main class="flex-grow border p-4 rounded-md h-full overflow-y-auto">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>
