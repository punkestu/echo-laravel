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
    @include('includes.alert')
    @include('includes.header')
    @php
        $nav = [
            'Katalog' => route('dashboard.catalog'),
            'Gudang' => route('dashboard.item'),
            'Tipe Item' => route('dashboard.item-type'),
        ];
    @endphp
    <div class="flex flex-col md:flex-row gap-x-2 px-4 md:h-[85vh] mt-4 overflow-y-auto">
        <nav class="md:w-[30%] lg:w-[15%] hidden md:flex flex-col gap-2 p-4 bg-light rounded-md">
            <h3 class="font-bold text-xl">Main Menu</h3>
            @foreach ($nav as $name => $route)
                <a class="underline {{ url()->current() == $route ? 'opacity-100' : 'opacity-50' }}"
                    href="{{ $route }}">{{ $name }}</a>
            @endforeach
        </nav>
        <nav class="flex md:hidden gap-1 overflow-x-auto">
            @foreach ($nav as $name => $route)
                <a class="{{ url()->current() == $route ? 'bg-light border' : 'underline' }} px-2 py-1 rounded-t-md"
                    href="{{ $route }}">{{ $name }}</a>
            @endforeach
        </nav>
        <main class="md:w-[85%] border p-4 rounded-b-md md:rounded-md h-full overflow-y-auto">
            @yield('content')
        </main>
    </div>
    @include('includes.footer')
    @yield('scripts')
</body>

</html>
