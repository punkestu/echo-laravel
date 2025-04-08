@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Ubah Item</h3>
            <p class="text-sm text-justify hidden md:block">
                Ubah item ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.item') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded-md">x Kembali</a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Item</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama item" value="{{ old('name') ?? $item->name }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi item">{{ old('description') ?? $item->description }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-sm">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="thumb" class="block text-sm font-medium text-gray-700">Foto Item</label>
                <input type="file" name="thumb" id="thumb" accept=".jpg,.jpeg,.png,.gif"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @if ($errors->has('thumb'))
                    <p class="text-red-500 text-sm">{{ $errors->first('thumb') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Item</label>
                <div id="type-list" class="flex gap-2">
                    @if (old('types'))
                        @foreach (old('types') as $type)
                            <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                                <span>{{ $itemtypes->find($type)->name }}</span>
                                <input type="hidden" name="types[]" value="{{ $type }}">
                                <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                            </div>
                        @endforeach
                    @else
                        @foreach ($item->itemTypes as $type)
                            <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                                <span>{{ $itemtypes->find($type)->name }}</span>
                                <input type="hidden" name="types[]" value="{{ $type }}">
                                <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <select id="type"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>Pilih tipe item</option>
                    @foreach ($itemtypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('types'))
                    <p class="text-red-500 text-sm">{{ $errors->first('types') }}</p>
                @endif
            </div>
            <div class="mb-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex-grow">
                    <label for="qty" class="block text-sm font-medium text-gray-700">Jumlah Total</label>
                    <input type="number" name="qty" id="qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item" value="{{ old('qty') ?? $item->qty }}">
                    @if ($errors->has('qty'))
                        <p class="text-red-500 text-sm">{{ $errors->first('qty') }}</p>
                    @endif
                </div>
                <div class="flex-grow">
                    <label for="good_qty" class="block text-sm font-medium text-gray-700">Jumlah Kondisi Bagus</label>
                    <input type="number" name="good_qty" id="good_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item bagus" value="{{ old('good_qty') ?? $item->good_qty }}">
                    @if ($errors->has('good_qty'))
                        <p class="text-red-500 text-sm">{{ $errors->first('good_qty') }}</p>
                    @endif
                </div>
                <div class="flex-grow">
                    <label for="bad_qty" class="block text-sm font-medium text-gray-700">Jumlah Kondisi Rusak</label>
                    <input type="number" name="bad_qty" id="bad_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item rusak" value="{{ old('bad_qty') ?? $item->bad_qty }}">
                    @if ($errors->has('bad_qty'))
                        <p class="text-red-500 text-sm">{{ $errors->first('bad_qty') }}</p>
                    @endif
                </div>
                <div class="flex-grow">
                    <label for="rent_qty" class="block text-sm font-medium text-gray-700">Jumlah Disewa</label>
                    <input type="number" name="rent_qty" id="rent_qty" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan jumlah total item disewa" value="{{ old('rent_qty') ?? $item->rent_qty }}">
                    @if ($errors->has('rent_qty'))
                        <p class="text-red-500 text-sm">{{ $errors->first('rent_qty') }}</p>
                    @endif
                </div>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="flex-grow">
                    <label for="base_price" class="block text-sm font-medium text-gray-700">Harga Normal</label>
                    <input type="number" name="base_price" id="base_price" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan harga normal" value="{{ old('base_price') ?? $item->base_price }}">
                    @if ($errors->has('base_price'))
                        <p class="text-red-500 text-sm">{{ $errors->first('base_price') }}</p>
                    @endif
                </div>
                <div class="flex-grow">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga Sekarang</label>
                    <input type="number" name="price" id="price" required
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan harga sekarang" value="{{ old('price') ?? $item->price }}">
                    @if ($errors->has('price'))
                        <p class="text-red-500 text-sm">{{ $errors->first('price') }}</p>
                    @endif
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
