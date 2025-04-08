@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Ubah Tipe Item</h3>
            <p class="text-sm text-justify hidden md:block">
                Ubah tipe item ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.item-type') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded-md">x Kembali</a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.item-type.update', $itemtype->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Item</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama item" value="{{ old('name') ?? $itemtype->name }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan
                Tipe
                Item</button>
        </form>
    </section>
@endsection
