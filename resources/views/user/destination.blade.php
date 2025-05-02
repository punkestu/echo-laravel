@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Destinasi</h3>
        <p class="text-sm text-justify">
            Cari preferensi destinasi yang kamu inginkan disini
        </p>
    </section>
    <section class="flex justify-center gap-2 flex-wrap">
        <div class="h-96 flex flex-col gap-4 justify-center items-center">
            <div>
                <h1 class="font-black text-xl text-center">Belum Siap</h1>
                <p class="text-center">
                    Bersiaplah! fitur dalam pembangunan
                </p>
            </div>
            <a class="bg-light px-3 py-1 rounded-md" href="{{ route('home') }}">Kembali</a>
        </div>
    </section>
@endsection
