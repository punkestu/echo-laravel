<header class="flex items-center justify-center md:justify-between px-4 py-2 flex-wrap gap-4">
    <a href="/">
        <img src="/images/logo/xlcombine.svg" alt="Logo Echo" class="h-12">
    </a>
    <aside class="flex items-center gap-4">
        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="underline">Dashboard</a>
            @else
                <a href="{{ route('catalog') }}" class="underline">Katalog</a>
                <a href="{{ route('cart') }}" class="underline flex relative">Keranjang <span
                        class="w-3 h-3 rounded-full absolute -right-2 bg-red-500"></span></a>
            @endif
            <a href="{{ route('auth.logout') }}" class="bg-red-500 text-white rounded-sm px-3 py-1">Logout</a>
        @endauth
        @guest
            <a href="{{ route('catalog') }}" class="underline">Katalog</a>
            <a href="/#auth" class="bg-light rounded-sm px-3 py-1">Masuk / Daftar</a>
        @endguest
    </aside>
</header>
