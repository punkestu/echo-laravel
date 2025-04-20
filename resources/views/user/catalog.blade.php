@extends('user.layout')
@section('content')
    <section class="mb-2">
        <aside class="flex justify-between">
            <h3 class="text-lg md:text-xl font-bold">Katalog</h3>
            @auth
                <a href="{{ route('cart') }}" class="px-3 py-1 rounded-md bg-light/75 hover:bg-light/100 duration-150 relative">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                    </svg>

                    @if (isset($cart_count) && $cart_count > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-2 text-xs">
                            {{ $cart_count }}
                        </span>
                    @endif
                </a>
            @endauth
        </aside>
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
            <button type="submit" class="text-sm bg-blue-500 text-white rounded-md px-3 py-1">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </button>
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
                <button onclick="closeModal('detail-catalog-modal')">
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </section>
            <div class="flex flex-col items-center">
                <img id="detail-catalog-image" src="" class="w-full h-56 object-contain rounded-t-lg mb-4">
                <h4 id="detail-catalog-name" class="text-xl font-bold mt-2"></h4>
                <p id="detail-catalog-price" class="text-gray-600 mt-1"></p>
                <p id="detail-catalog-description" class="text-gray-600 mt-1 text-center"></p>
                <div id="detail-catalog-items" class="flex justify-center flex-wrap gap-2 mt-4">
                </div>
                @auth
                    <div class="flex flex-col items-center gap-2 mt-2">
                        <div class="flex justify-center gap-1">
                            <button
                                class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border flex justify-center items-center"
                                onclick="maninputnum('addtocart-qty', -1)">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <input type="number" id="addtocart-qty"
                                class="p-2 text-sm w-1/2 border rounded-md text-center hide-num-btn">
                            <button
                                class="font-black p-2 w-1/4 rounded hover:bg-gray-300 border flex justify-center items-center"
                                onclick="maninputnum('addtocart-qty', 1)">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <button id="addtocart" onclick="addtocart(this)"
                            class="flex-grow bg-light/75 hover:bg-light duration-150 px-3 py-1 rounded-md w-full flex justify-center">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                            </svg>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function maninputnum(id, by) {
            const el = document.getElementById(id);
            const value = parseInt(el.value);
            if (isNaN(value) || value + by < 1) {
                el.value = 1;
            } else {
                el.value = Math.max(1, value + by);
            }
        }

        async function addtocart(el) {
            const id = el.getAttribute('catalog-id');
            const qty = document.getElementById('addtocart-qty').value;
            const url = "{{ route('cart.add') }}";
            const auth_token = await getToken();
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': `Bearer ${auth_token.token}`,
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        catalog_id: id,
                        qty: qty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        alert('Berhasil menambahkan ke keranjang');
                        closeModal('detail-catalog-modal');
                    } else {
                        alert('Gagal menambahkan ke keranjang. Coba lagi nanti.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function setDetailCatalog(id, name, price, description, image, items) {
            return () => {
                @auth
                document.getElementById('addtocart').setAttribute('catalog-id', id);
                document.getElementById('addtocart-qty').value = 1;
            @endauth
            document.getElementById('detail-catalog-name').innerText = name;
            document.getElementById('detail-catalog-price').innerText = 'Rp. ' + price.toLocaleString('id-ID') +
                ' / Hari';
            document.getElementById('detail-catalog-description').innerText = description;
            document.getElementById('detail-catalog-image').src = image != "/storage/" ? image :
                '/images/logo/normallight.svg';

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
