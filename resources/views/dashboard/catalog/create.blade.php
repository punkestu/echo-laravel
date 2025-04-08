@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Katalog Baru</h3>
            <p class="text-sm text-justify">
                Tambahkan katalog baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.catalog') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded-md">x Kembali</a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.catalog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Katalog</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama katalog">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi katalog"></textarea>
            </div>
            <div class="mb-4">
                <label for="thumb" class="block text-sm font-medium text-gray-700">Foto Katalog</label>
                <input type="file" name="thumb" id="thumb" accept=".jpg,.jpeg,.png,.gif"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="item" class="block text-sm font-medium text-gray-700">Item Katalog</label>
                <div id="item-list" class="flex gap-2">
                </div>
                <select id="item"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>Pilih tipe item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} | Rp.
                            {{ number_format($item->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan harga">
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan
                Item</button>
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        document.querySelector('#item').addEventListener('change', function(event) {
            const selectedItem = event.target.value;
            const selectedItemText = event.target.options[event.target.selectedIndex].text;
            document.querySelector("#item-list").insertAdjacentHTML('beforeend', `
                <div class="bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                    <span>${selectedItemText}</span>
                    <input type="hidden" name="items[]" value="${selectedItem}"> X
                    <input type="number" name="qty[]" class="bg-white text-black px-2 py-1 w-14 rounded-md">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                </div>
            `);
            event.target.value = "";
        });
    </script>
@endsection
