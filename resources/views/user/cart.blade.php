@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Keranjang</h3>
        <p class="text-sm text-justify">
            Ayo isi keranjangmu dan segera lakukan pemesanan. Pastikan semua katalog yang kamu pilih sudah sesuai dengan
            kebutuhanmu.
        </p>
    </section>
    <section class="flex gap-2">
        @if ($carts->isEmpty())
            <aside class="flex-grow flex justify-center items-center border rounded-md">
                <p class="text-lg text-gray-500">Keranjangmu kosong</p>
            </aside>
        @else
            <aside id="cart-list" class="flex-grow grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 items-start gap-4">
                @foreach ($carts as $index => $item)
                    <div id="cart-{{ $item->id }}" class="cart-item border p-2 rounded-md">
                        <label>
                            <input type="checkbox" name="catalog[{{ $index }}]" value="{{ $item->catalog->id }}"
                                class="w-6 h-6">
                            <img src="{{ $item->catalog->thumb_url ? '/storage/' . $item->catalog->thumb_url : '/images/logo/normallight.svg' }}"
                                alt="{{ $item->catalog->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            <h4 class="text-xl font-bold mt-2">{{ $item->catalog->name }}</h4>
                            <p class="text-gray-600 mt-1">Rp. {{ number_format($item->catalog->price, 0, ',', '.') }} /
                                Hari</p>
                        </label>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex gap-1">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border"
                                    onclick="maninputnum('addtocart-qty-{{ $index }}', -1)">-</button>
                                <input type="number" id="addtocart-qty-{{ $index }}"
                                    class="p-2 text-sm w-1/3 border rounded-md text-center hide-num-btn"
                                    value="{{ $item->qty }}">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border"
                                    onclick="maninputnum('addtocart-qty-{{ $index }}', 1)">+</button>
                            </div>
                            <button onclick="remfromcart(this)" cart-id={{ $item->id }}
                                id="remfromcart-{{ $index }}"
                                class="bg-red-500 text-white px-3 py-1 rounded-md">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </aside>
        @endif
        <aside class="border w-1/4 p-4 rounded-md min-h-[70vh]">
            <div class="flex flex-col gap-2">
                <h4 class="text-lg font-bold">Total</h4>
                <p class="text-gray-600">Rp. 0</p>
                @if (!$carts->isEmpty())
                    <button onclick="location.href=''" class="bg-blue-500 text-white px-3 py-1 rounded-md">Pesan</button>
                @endif
            </div>
        </aside>
    </section>
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

        async function remfromcart(el) {
            const cartId = el.getAttribute('cart-id');
            const url = "{{ route('cart.remove', ':id') }}".replace(':id', cartId);
            const auth_token = await getToken();
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': `Bearer ${auth_token.token}`,
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        cart_id: cartId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const cartElement = document.getElementById('cart-' + cartId);
                        cartElement.remove();
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            const cartList = document.getElementById('cart-list');
                            cartList.outerHTML = `<aside class="flex-grow flex justify-center items-center border rounded-md">
                                <p class="text-lg text-gray-500">Keranjangmu kosong</p>
                            </aside>`;
                        }
                        alert('Berhasil menghapus item dari keranjang');
                    } else {
                        alert('Gagal menghapus item dari keranjang');
                    }
                });
        }
    </script>
@endsection
