@php
    $nav = [
        'Dashboard' => ['onlyadmin' => true, 'route' => route('dashboard')],
        'Galeri' => ['route' => route('gallery')],
        'Destinasi' => ['route' => route('destination')],
        'Katalog' => ['route' => route('catalog'), 'cart' => auth()->check()],
    ];
@endphp
<header class="flex items-center justify-between px-4 pt-2 gap-4">
    <a href="/">
        <img src="/images/logo/xlcombine.svg" alt="Logo Echo" class="h-12">
    </a>
    <aside class="flex items-center gap-4">
        <div class="hidden sm:flex gap-4">
            @foreach ($nav as $name => $prop)
                @if ((!auth()->check() || !auth()->user()->isAdmin()) && ($prop['onlyadmin'] ?? false))
                    @continue
                @endif
                <a href="{{ $prop['route'] }}" class="underline relative">{{ $name }}
                    @if (($prop['cart'] ?? false) && isset($cart_count) && $cart_count > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-2 text-xs">
                            {{ $cart_count }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
        @auth
            <a href="{{ route('profile') }}">
                <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        @endauth
        @guest
            <a href="/#auth" class="bg-light rounded-sm px-3 py-1">Masuk / Daftar</a>
        @endguest
    </aside>
</header>
<nav class="flex sm:hidden flex-col items-center pb-2">
    <div class="flex flex-col gap-2 max-h-0 overflow-hidden duration-500">
        @foreach ($nav as $name => $prop)
            @if ((!auth()->check() || !auth()->user()->isAdmin()) && ($prop['onlyadmin'] ?? false))
                @continue
            @endif
            <a href="{{ $prop['route'] }}" class="relative hover:underline">{{ $name }}
                @if (($prop['cart'] ?? false) && isset($cart_count) && $cart_count > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-2 text-xs">
                        {{ $cart_count }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>
    <button onclick="toggleNav(this)" class="w-full flex justify-center mt-1">
        <svg aria-label="up" class="w-6 h-6 text-gray-800 hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m5 15 7-7 7 7" />
        </svg>
        <svg aria-label="down" class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
          </svg>          
    </button>
</nav>

<script>
    function toggleNav(executor) {
        const nav = document.querySelector('nav > div');

        nav.classList.toggle('max-h-0');
        nav.classList.toggle('max-h-96');
        if (nav.classList.contains('max-h-0')) {
            executor.querySelector("[aria-label='up']").classList.add('hidden');
            executor.querySelector("[aria-label='down']").classList.remove('hidden');
        } else {
            executor.querySelector("[aria-label='up']").classList.remove('hidden');
            executor.querySelector("[aria-label='down']").classList.add('hidden');
        }
    }
</script>
