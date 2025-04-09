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
            <aside id="cart-list" class="self-start flex-grow grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($carts as $item)
                    <div id="cart-{{ $item->id }}" class="cart-item flex flex-col justify-between border p-2 rounded-md">
                        <label>
                            <input type="checkbox" value="{{ $item->id }}" class="w-6 h-6" onchange="setOrder(this)"
                                data-catalog='@json($item->catalog)'>
                            <img src="{{ $item->catalog->thumb_url ? '/storage/' . $item->catalog->thumb_url : '/images/logo/normallight.svg' }}"
                                alt="{{ $item->catalog->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            <h4 class="text-xl font-bold mt-2">{{ $item->catalog->name }}</h4>
                            <p class="text-gray-600 mt-1">Rp. {{ number_format($item->catalog->price, 0, ',', '.') }} /
                                Hari</p>
                        </label>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex gap-1">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border"
                                    onclick="maninputnum('cart-qty-{{ $item->id }}', -1)">-</button>
                                <input type="number" id="cart-qty-{{ $item->id }}"
                                    class="p-2 text-sm w-1/3 border rounded-md text-center hide-num-btn"
                                    value="{{ $item->qty }}">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border"
                                    onclick="maninputnum('cart-qty-{{ $item->id }}', 1)">+</button>
                            </div>
                            <button onclick="remfromcart(this)" cart-id={{ $item->id }}
                                class="bg-red-500 text-white px-3 py-1 rounded-md">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </aside>
        @endif
        <div id="toggler" class="fixed bottom-2 right-2 flex lg:hidden justify-end z-0 mt-2 duration-500">
            <button onclick="toggleorder()" class="bg-light text-dark px-3 py-2 rounded-lg border">Pesan Sekarang</button>
        </div>
        <aside id="order-form"
            class="bg-netral border w-5/6 lg:w-1/4 z-20 lg:z-0 absolute -right-full lg:relative lg:right-0 px-4 py-4 rounded-md overflow-x-hidden min-h-[70vh] duration-500">
            <div class="flex flex-col gap-2">
                <div class="lg:hidden flex justify-end">
                    <button onclick="toggleorder()" class="bg-red-500 px-3 py-1 rounded-md text-white">x Close</button>
                </div>
                <h4 class="text-lg font-bold">Total</h4>
                <p id="total" class="text-gray-600">Rp. 0</p>
                <button onclick="toggleModal('order-modal', setOrderText)"
                    class="bg-blue-500 text-white px-3 py-1 rounded-md">Pesan</button>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" class="border px-2 py-1 rounded"
                    placeholder="Masukan Nama Lengkap ...">
                <label for="nohp">No. HP</label>
                <input type="text" name="nohp" id="nohp" class="border px-2 py-1 rounded"
                    placeholder="Masukan Nomor HP ...">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" class="border px-2 py-1 rounded resize-none"
                    placeholder="Masukan Alamat Lengkap ..."></textarea>
                <label for="jaminan">Jaminan</label>
                <select name="jaminan" id="jaminan" class="border px-2 py-1 rounded">
                    <option value="KTP">KTP</option>
                    <option value="SIM">SIM</option>
                </select>
                <label for="pengambilan">Pengambilan</label>
                <select name="pengambilan" id="pengambilan" class="border px-2 py-1 rounded">
                    <option value="Ambil di Rumah">Ambil di Rumah</option>
                    <option value="COD">COD</option>
                </select>
                <label for="tempatcod">Tempat COD</label>
                <textarea name="tempatcod" id="tempatcod" rows="3" class="border px-2 py-1 rounded resize-none"
                    placeholder="Masukan Tempat COD ..."></textarea>
                <label for="jamambil">Jam Pengambilan</label>
                <input type="datetime-local" name="jamambil" id="jamambil" class="border px-2 py-1 rounded">
                <label for="jamkembali">Jam Pengembalian</label>
                <input type="datetime-local" name="jamkembali" id="jamkembali" class="border px-2 py-1 rounded">
            </div>
        </aside>
    </section>
    <div id="order-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('order-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 min-w-1/2 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <section class="flex justify-end mb-2">
                <button onclick="closeModal('order-modal')"
                    class="bg-red-500 text-white px-3 py-1 rounded-md">Close</button>
            </section>
            <div class="flex flex-col gap-2">
                <textarea readonly class="border rounded-md w-full resize-none p-2" rows="10"></textarea>
                <div class="flex gap-2">
                    <button class="border rounded-md px-3 py-1">Copy</button>
                    <button class="bg-green-500 border rounded-md px-3 py-1">Pesan ke Whatsapp</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const formatCurrency = (value) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value).replace('Rp', '');

        function toggleorder() {
            document.querySelector('#order-form').classList.toggle('-right-full');
            document.querySelector('#order-form').classList.toggle('right-0');
        }

        function openorder() {
            document.querySelector('#order-form').classList.remove('-right-full');
            document.querySelector('#order-form').classList.add('right-0');
        }

        function closeorder() {
            document.querySelector('#order-form').classList.remove('right-0');
            document.querySelector('#order-form').classList.add('-right-full');
        }

        function setOrderText() {
            const orderText = document.querySelector('#order-modal textarea');
            const nama = document.getElementById('name').value;
            const nohp = document.getElementById('nohp').value;
            const alamat = document.getElementById('alamat').value;
            const jaminan = document.getElementById('jaminan').value;
            const pengambilan = document.getElementById('pengambilan').value;
            const tempatcod = document.getElementById('tempatcod').value;
            const jamambil = document.getElementById('jamambil').value;
            const jamkembali = document.getElementById('jamkembali');
            orderText.value = '';
            var total = 0;
            orderText.value +=
                `Form Peminjaman Barang @echo.outdoor\nNama : ${nama}\nNo. HP : ${nohp}\nAlamat : ${alamat}\nBarang yang disewa : \n`;
            orders.forEach((idcart) => {
                const cart = document.querySelector(`input[value="${idcart}"]`);
                const catalog = cart.getAttribute('data-catalog');
                const catalogData = JSON.parse(catalog);
                const qty = document.getElementById('cart-qty-' + idcart).value;
                const subtotal = catalogData.price * qty;
                total += subtotal;
                orderText.value +=
                    `\t- ${catalogData.name} (Rp. ${formatCurrency(catalogData.price)}) x ${qty} = ${formatCurrency(subtotal)}\n`;
            });
            orderText.value += `\tTotal: Rp. ${formatCurrency(total)}\n`;
            orderText.value +=
                `Jaminan : ${jaminan}\nPengambilan : ${pengambilan}\nTempat COD : ${tempatcod}\nJam Pengambilan : ${jamambil}\nJam Pengembalian : ${jamkembali}\n\nNote : Penyewaan berlaku 24 jam, lebih dari jangka waktu tersebut akan dikenakan charge 5k/jam`;
        }

        function maninputnum(id, by) {
            const el = document.getElementById(id);
            const value = parseInt(el.value);
            if (isNaN(value) || value + by < 1) {
                el.value = 1;
            } else {
                el.value = Math.max(1, value + by);
            }

            calculateTotal();
        }

        const orders = [];

        function setOrder(el) {
            const idcart = el.value;

            if (el.checked) {
                orders.push(idcart);
            } else {
                orders.splice(orders.indexOf(idcart), 1);
            }

            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            orders.forEach((idcart) => {
                const cart = document.querySelector(`input[value="${idcart}"]`);
                const catalog = cart.getAttribute('data-catalog');
                const catalogData = JSON.parse(catalog);
                const qty = document.getElementById('cart-qty-' + idcart).value;
                const subtotal = catalogData.price * qty;
                total += subtotal;
            });
            document.getElementById('total').innerText = 'Rp. ' + formatCurrency(total);
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
