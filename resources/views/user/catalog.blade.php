@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Katalog</h3>
        <p class="text-sm text-justify">
            Banyak item atau paket yang tersedia di sini. Buat jalan-jalanmu lebih mudah bersama Echo.
        </p>
    </section>
    <section class="mb-2">
        <form id="filter-form" action="{{ route('catalog') }}" method="GET" class="flex gap-2">
            <select onchange="document.querySelector('#filter-form').submit()" name="filter_type" id="filter_type"
                class="text-sm border border-gray-300 rounded-md px-2 py-1">
                <option value="">Semua Tipe</option>
                @foreach ($itemtypes as $itemtype)
                    <option value="{{ $itemtype->id }}" {{ request('filter_type') == $itemtype->id ? 'selected' : '' }}>
                        {{ $itemtype->name }}</option>
                @endforeach
            </select>
            <input type="text" name="search" id="search" placeholder="Cari katalog..."
                class="text-sm border border-gray-300 rounded-md px-2 py-1 w-full" value="{{ $search }}">
            <button type="submit" class="text-sm bg-blue-500 text-white rounded-md px-3 py-1">Cari</button>
        </form>
    </section>
    <section>
        @if ($catalogs->isEmpty())
            <div class="flex justify-center items-center h-[60vh]">
                <p class="text-lg text-gray-500">Tidak ada katalog yang ditemukan.</p>
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach ($catalogs as $item)
                <button
                    onclick="toggleModal('detail-catalog-modal', setDetailCatalog({{ $item->id }}, '{{ $item->name }}', {{ $item->price }}, '{{ $item->description }}', '/storage/{{ $item->thumb_url }}', {{ $item->catalogItems }}))"
                    class="bg-white shadow-md rounded-lg p-4" title="{{ $item->description }}"
                    popovertarget='detail-catalog'>
                    <img src="{{ $item->thumb_url ? '/storage/' . $item->thumb_url : '/images/logo/normallight.svg' }}"
                        alt="{{ $item->name }}" class="w-full h-56 object-cover rounded-t-lg">
                    <h4 class="text-xl font-bold mt-2">{{ $item->name }}</h4>
                    <p class="text-gray-600 mt-1">Rp. {{ number_format($item->price, 0, ',', '.') }} / Hari</p>
                </button>
            @endforeach
        </div>
    </section>
    <div id="detail-catalog-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('detail-catalog-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <section class="flex justify-end mb-2">
                <button onclick="closeModal('detail-catalog-modal')"
                    class="bg-red-500 text-white px-3 py-1 rounded-md">Close</button>
            </section>
            <div class="flex flex-col items-center">
                <img id="detail-catalog-image" src="" class="w-full h-56 object-contain rounded-t-lg mb-4">
                <h4 id="detail-catalog-name" class="text-xl font-bold mt-2"></h4>
                <p id="detail-catalog-price" class="text-gray-600 mt-1"></p>
                <p id="detail-catalog-description" class="text-gray-600 mt-1 text-center"></p>
                <div id="detail-catalog-items" class="flex justify-center flex-wrap gap-2 mt-4">
                    {{-- <span class="bg-blue-400 text-white rounded-full px-3 py-1">name x qty</span> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setDetailCatalog(id, name, price, description, image, items) {
            return () => {
                document.getElementById('detail-catalog-name').innerText = name;
                document.getElementById('detail-catalog-price').innerText = 'Rp. ' + price.toLocaleString('id-ID') +
                    ' / Hari';
                document.getElementById('detail-catalog-description').innerText = description;
                document.getElementById('detail-catalog-image').src = image != "/storage/" ? image : '/images/logo/normallight.svg';

                const itemsContainer = document.getElementById('detail-catalog-items');
                itemsContainer.innerHTML = '';
                items.forEach(item => {
                    const itemElement = document.createElement('span');
                    itemElement.className = 'bg-blue-400 text-white rounded-full px-3 py-1';
                    itemElement.innerText = item.item.name + ' x ' + item.qty;
                    itemsContainer.appendChild(itemElement);
                });
            }
        }
    </script>
@endsection
