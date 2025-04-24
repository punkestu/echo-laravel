@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Pelanggan Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Tambahkan pelanggan baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan
                benar.
            </p>
        </div>
        <a href="{{ route('dashboard.customer') }}">
            <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama item" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="phone" id="phone" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama item" value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                    <p class="text-red-500 text-sm">{{ $errors->first('phone') }}</p>
                @endif
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan</button>
        </form>
    </section>
@endsection
