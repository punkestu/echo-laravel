@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Profile</h3>
        <p class="text-sm text-justify">
            Selamat datang di halaman profil Anda. Di sini Anda dapat melihat informasi akun Anda, termasuk nama, email,
            dan
            foto profil. Jika Anda ingin memperbarui informasi akun Anda, silakan kunjungi halaman pengaturan akun.
        </p>
    </section>
    <section class="mb-2">
        <h4 class="text-sm md:text-lg font-bold mb-1">Bio</h4>
        <form action="{{ route('set-nohp') }}" method="post">
            @csrf
            <div class="flex flex-col gap-2">
                <label for="name" class="text-sm">Nama</label>
                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                    class="text-sm border border-gray-300 rounded-md px-2 py-1 bg-gray-300" disabled>
                <label for="email" class="text-sm">Email</label>
                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
                    class="text-sm border border-gray-300 rounded-md px-2 py-1 bg-gray-300" disabled>
                <label for="nohp" class="text-sm">Nomor HP</label>
                @if (!auth()->user()->nohp)
                    <input type="text" name="nohp" id="nohp" value="{{ auth()->user()->nohp }}"
                        class="text-sm border border-gray-300 rounded-md px-2 py-1" placeholder="Nomor HP...">
                    <button type="submit" class="bg-blue-500 text-white rounded-md px-3 py-1 mt-2">Simpan</button>
                @else
                    <input type="text" name="nohp" id="nohp" value="{{ auth()->user()->nohp }}"
                        class="text-sm border border-gray-300 rounded-md px-2 py-1 bg-gray-300" disabled>
                @endif
            </div>
        </form>
    </section>
    <section class="mb-2">
        <h4 class="text-sm md:text-lg font-bold mb-1">Zona Bahaya</h4>
        <a href="{{ route('auth.logout') }}"
            class="border border-red-500 px-3 py-1 rounded-md text-red-500 hover:text-white hover:bg-red-500 duration-150">Keluar</a>
    </section>
@endsection
@section('scripts')
@endsection
