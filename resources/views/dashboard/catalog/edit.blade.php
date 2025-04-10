@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Katalog Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Tambahkan katalog baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.catalog') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded-md">x Kembali</a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.catalog.update', $catalog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Katalog</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama katalog" value="{{ old('name') ?? $catalog->name }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi katalog">{{ old('description') ?? $catalog->description }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-sm">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="thumb" class="block text-sm font-medium text-gray-700">Foto Katalog</label>
                <input type="file" name="thumb" id="thumb" accept=".jpg,.jpeg,.png,.gif"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @if ($errors->has('thumb'))
                    <p class="text-red-500 text-sm">{{ $errors->first('thumb') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="item" class="block text-sm font-medium text-gray-700">Item Katalog</label>
                <div id="item-list" class="flex gap-2">
                    @if (old('items'))
                        @foreach (old('items') as $key => $itemqty)
                            @php
                                $citem = $items->find($itemqty['id']);
                            @endphp
                            <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                                <span>{{ $citem->name }} | Rp. {{ number_format($citem->price, 0, '.', ',') }}</span> X
                                <input type="hidden" name="items[{{ $key }}][id]" value="{{ $itemqty['id'] }}">
                                <input type="number" name="items[{{ $key }}][qty]" value="{{ $itemqty['qty'] }}"
                                    class="bg-white text-black px-2 py-1 w-14 rounded-md">
                                <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                            </div>
                        @endforeach
                    @else
                        @foreach ($catalog->catalogItems as $citem)
                            <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                                <span>{{ $citem->item->name }} | Rp. {{ number_format($citem->item->price, 0, '.', ',') }}</span> X
                                <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $citem->item->id }}">
                                <input type="number" name="items[{{ $loop->index }}][qty]"
                                    value="{{ $citem->qty }}" class="bg-white text-black px-2 py-1 w-14 rounded-md">
                                <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                            </div>
                        @endforeach
                    @endif
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
                @if ($errors->has('items.*.id') || $errors->has('items.*.qty') || $errors->has('items') || $errors->has('items.*'))
                    @php
                        $firstError = collect($errors->getMessages())
                            ->filter(function ($_, $key) {
                                return str_starts_with($key, 'items');
                            })
                            ->flatten()
                            ->first();
                    @endphp
                    <p class="text-red-500 text-sm">
                        {{ $firstError }}
                @endif
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan harga" value="{{ old('price') ?? $catalog->price }}">
                @if ($errors->has('price'))
                    <p class="text-red-500 text-sm">{{ $errors->first('price') }}</p>
                @endif
            </div>
            <button type="submit"
                class="bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Simpan
                Item</button>
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        var count = {{ old('items') ? count(old('items')) : count($catalog->items) }};
        document.querySelector('#item').addEventListener('change', function(event) {
            const selectedItem = event.target.value;
            const selectedItemText = event.target.options[event.target.selectedIndex].text;
            document.querySelector("#item-list").insertAdjacentHTML('beforeend', `
                <div class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">
                    <span>${selectedItemText}</span>
                    <input type="hidden" name="items[${count}][id]" value="${selectedItem}"> X
                    <input type="number" name="items[${count}][qty]" class="bg-white text-black px-2 py-1 w-14 rounded-md">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">x</button>
                </div>
            `);
            event.target.value = "";
            count++;
        });
    </script>
@endsection
