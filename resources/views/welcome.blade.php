<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Echo</title>
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
    <main class="px-6 py-2">
        <section class="relative h-[85vh] rounded-md">
            <div class="w-full h-full flex flex-col gap-2 justify-center items-center bg-netral/65 text-black/85">
                <h1 class="text-xl md:text-4xl font-bold text-center">Selamat datang di Echo</h1>
                <h2 class="text-sm md:text-xl font-bold text-center">Gema Petualangan Dimulai di Sini</h2>
            </div>
            <img src="/images/illustration/holly-mandarich-UVyOfX3v0Ls-unsplash.jpg" alt="a woman hiking"
                class="w-full h-full object-cover absolute top-0 -z-10 rounded-md">
        </section>
        <section class="mt-16 flex flex-wrap items-center justify-center gap-8">
            <img src="/images/logo/normallight.svg" alt="Logo Echo Normal" class="h-[240px]">
            <div class="flex flex-col gap-2 md:w-1/2">
                <h3 class="text-lg md:text-2xl font-bold">Apa itu Echo?</h3>
                <p class="text-sm md:text-lg text-justify">Echo adalah tempat dimana anda dapat menemukan dan menyewa
                    berbagai peralatan outdoor yang anda butuhkan. Mulai dari peralatan hiking, camping, hingga
                    alat-alat untuk kegiatan outdoor lainnya.</p>
                <p class="text-sm md:text-lg text-justify">Kami menyediakan berbagai pilihan peralatan outdoor yang dapat anda
                    pilih sesuai dengan kebutuhan anda. Anda dapat melakukan booking peralatan tersebut secara online
                    melalui website kami.</p>
            </div>
        </section>
        <section class="mt-16">
            <h3 class="text-lg md:text-2xl font-bold">Mau sewa apa aja?</h3>
            <p class="text-sm md:text-lg text-justify">
                Mau sewa peralatan hiking, camping, atau alat-alat outdoor lainnya? Kami punya semua yang anda butuhkan.
            </p>
            <div class="grid md:grid-cols-3 xl:grid-cols-5 gap-4 mt-4">
                <a href="/catalog?filter_type=kursi">
                    <div class="h-full bg-light rounded-md p-4 flex flex-col items-center gap-2">
                        <img src="/images/illustration/kursi.png" alt="Kursi" class="h-48">
                        <h4 class="text-lg font-bold">Kursi</h4>
                    </div>
                </a>
                <a href="/catalog?filter_type=meja">
                    <div class="h-full bg-light rounded-md p-4 flex flex-col items-center gap-2">
                        <img src="/images/illustration/meja.png" alt="Meja" class="h-48">
                        <h4 class="text-lg font-bold">Meja</h4>
                    </div>
                </a>
                <a href="/catalog?filter_type=kompor">
                    <div class="h-full bg-light rounded-md p-4 flex flex-col items-center gap-2">
                        <img src="/images/illustration/kompor.png" alt="Kompor" class="h-48">
                        <h4 class="text-lg font-bold">Kompor</h4>
                    </div>
                </a>
                <a href="/catalog?filter_type=kamera">
                    <div class="h-full bg-light rounded-md p-4 flex flex-col items-center gap-2">
                        <img src="/images/illustration/camera.png" alt="Kamera" class="h-48">
                        <h4 class="text-lg font-bold">Kamera Digital</h4>
                    </div>
                </a>
                <a href="/catalog">
                    <div class="h-full bg-light rounded-md p-4 flex flex-col items-center justify-center gap-2">
                        <h4 class="text-lg font-bold text-center">Lihat Lainnya <br> di Katalog</h4>
                    </div>
                </a>
        </section>
        <section class="mt-16 flex justify-center">
            <div class="md:w-3/4">
                <h3 class="text-lg md:text-2xl font-bold">Aturan Main</h3>
                <p class="text-sm md:text-lg text-justify">
                    Sebelum melakukan booking, ada baiknya anda membaca dan memahami aturan main kami.
                    Kami ingin memastikan bahwa anda mendapatkan pengalaman terbaik saat menggunakan layanan kami.
                </p>
                <ul class="text-sm md:text-lg mb-4 ml-2">
                    <li class="text-justify mt-2">
                        <strong>1.</strong> Keterlambatan pengembalian dikenakan charge 5k/jam.
                    </li>
                    <li class="text-justify mt-2">
                        <strong>2.</strong> Penyewa wajib menyimpan fotokopi KTP atau SIM.
                    </li>
                    <li class="text-justify mt-2">
                        <strong>3.</strong> Kerusakan peralatan dikenakan biaya senilai harga barang.
                    </li>
                </ul>
                <div class="flex">
                    <a href="/images/aturan-main.png" target="_blank"
                        class="text-sm md:text-lg bg-light px-4 py-2 rounded-sm flex justify-center items-center gap-2 w-full md:w-auto">Baca Lebih Lengkap di Sini
                        <img src="/icons/share.png" alt="share" class="h-6"></a>
                </div>
            </div>
        </section>
        @guest
            <section class="pt-16 flex gap-4 overflow-x-auto" id="auth">
                <aside class="bg-light rounded-lg p-3 md:p-8 flex-grow">
                    <h3 class="text-lg md:text-2xl font-bold">Daftar</h3>
                    <p class="text-sm md:text-lg">
                        Mau booking peralatan outdoor? Join dulu dong!
                    </p>
                    <form action="{{ route('auth.register') }}" method="post" class="mt-4" id="register">
                        @csrf
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="register-name" class="text-sm md:text-lg font-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="register-name"
                                class="text-sm md:text-lg border border-black rounded-md p-2" placeholder="Nama Lengkap" required>
                            @if ($errors->has('name'))
                                <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="register-email" class="text-sm md:text-lg font-bold">Email</label>
                            <input type="email" name="email" id="register-email"
                                class="text-sm md:text-lg border border-black rounded-md p-2" placeholder="Email" required>
                            @if ($errors->has('email'))
                                <p class="text-red-500 text-sm">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="register-password" class="text-sm md:text-lg font-bold">Password</label>
                            <input type="password" name="password" id="register-password"
                                class="text-sm md:text-lg border border-black rounded-md p-2" placeholder="Password" required>
                            @if ($errors->has('password'))
                                <p class="text-red-500 text-sm">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <button type="submit"
                            class="text-sm md:text-lg w-full bg-dark text-light rounded-md px-4 py-2 mt-2 hover:bg-dark/80 transition duration-200">Daftar</button>
                    </form>
                </aside>
                <aside class="bg-light rounded-lg p-3 md:p-8">
                    <h3 class="text-lg md:text-2xl font-bold">Masuk</h3>
                    <p class="text-sm md:text-lg">
                        Udah punya akun? Ayo masuk dan booking sekarang!
                    </p>
                    <form action="{{ route('auth.login') }}" method="post" class="mt-4" id="login">
                        @csrf
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="login-email" class="text-sm md:text-lg font-bold">Email</label>
                            <input type="email" name="email" id="login-email"
                                class="text-sm md:text-lg border border-black rounded-md p-2" placeholder="Email" required>
                        </div>
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="login-password" class="text-sm md:text-lg font-bold">Password</label>
                            <input type="password" name="password" id="login-password"
                                class="text-sm md:text-lg border border-black rounded-md p-2" placeholder="Password" required>
                        </div>
                        <button type="submit"
                            class="text-sm md:text-lg w-full bg-dark text-light rounded-md px-4 py-2 mt-2 hover:bg-dark/80 transition duration-200">Masuk</button>
                    </form>
                </aside>
            </section>
        @endguest
    </main>
    @include('includes.footer')
</body>

</html>
