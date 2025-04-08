@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Item Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Tambahkan item baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.item') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded-md">x Kembali</a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Item</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama item">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi item"></textarea>
            </div>
            <div class="mb-4">
                <label for="thumb" class="block text-sm font-medium text-gray-700">Foto Item</label>
                <input type="file" name="thumb" id="thumb" accept=".jpg,.jpeg,.png,.gif"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Item</label>
                <div id="type-list" class="flex gap-2">
                </div>
                <select id="type"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>Pilih tipe item</option>
                    @foreach ($itemtypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex-grow">
                    <label for="qty" class="block text-sm font-medium text-gray-700">Jumlah Total</label>
                    <input type="number" name="qty" id="qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item">
                </div>
                <div class="flex-grow">
                    <label for="good_qty" class="block text-sm font-medium text-gray-700">Jumlah Kondisi Bagus</label>
                    <input type="number" name="good_qty" id="good_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item bagus">
                </div>
                <div class="flex-grow">
                    <label for="bad_qty" class="block text-sm font-medium text-gray-700">Jumlah Kondisi Rusak</label>
                    <input type="number" name="bad_qty" id="bad_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item rusak">
                </div>
                <div class="flex-grow">
                    <label for="rent_qty" class="block text-sm font-medium text-gray-700">Jumlah Disewa</label>
                    <input type="number" name="rent_qty" id="rent_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item disewa">
                </div>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="flex-grow">
                    <label for="base_price" class="block text-sm font-medium text-gray-700">Harga Normal</label>
                    <input type="number" name="base_price" id="base_price" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan harga normal">
                </div>
                <div class="flex-grow">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga Sekarang</label>
                    <input type="number" name="price" id="price" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan harga sekarang">
                </div>
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan
                Item</button>
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        document.querySelector('#type').addEventListener('change', function(event) {
            const selectedType = event.target.value;
            const selectedTypeText = event.target.options[event.target.selectedIndex].text;
            document.querySelector("#type-list").insertAdjacentHTML('beforeend', `
                <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                    <span>${selectedTypeText}</span>
                    <input type="hidden" name="types[]" value="${selectedType}">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                </div>
            `);
            event.target.value = "";
        });
    </script>
@endsection
