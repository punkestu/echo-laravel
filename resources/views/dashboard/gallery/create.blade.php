@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Gambar Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Tambahkan gambar baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan
                benar.
            </p>
        </div>
        <a href="{{ route('dashboard.gallery') }}">
            <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="title" id="title" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan judul ..." value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <p class="text-red-500 text-sm">{{ $errors->first('title') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi ...">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-sm">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @if ($errors->has('image'))
                    <p class="text-red-500 text-sm">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                <input type="number" name="priority" id="priority" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan prioritas ..." value="{{ old('priority') }}">
                @if ($errors->has('priority'))
                    <p class="text-red-500 text-sm">{{ $errors->first('priority') }}</p>
                @endif
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan</button>
        </form>
    </section>
@endsection
