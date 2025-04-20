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
                        <div class="flex justify-between mt-2">
                            <div class="flex gap-1">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border flex justify-center items-center"
                                    onclick="maninputnum('cart-qty-{{ $item->id }}', -1)">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="number" id="cart-qty-{{ $item->id }}"
                                    class="p-2 text-sm w-1/3 border rounded-md text-center hide-num-btn"
                                    value="{{ $item->qty }}">
                                <button class="font-black p-1 w-1/4 rounded hover:bg-gray-300 border flex justify-center items-center"
                                    onclick="maninputnum('cart-qty-{{ $item->id }}', 1)">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <button onclick="remfromcart(this)" cart-id={{ $item->id }}
                                class="bg-red-500 text-white px-3 py-1 rounded-md">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </aside>
        @endif
        <div id="toggler" class="fixed bottom-2 right-2 flex lg:hidden justify-end z-0 mt-2 duration-500">
            <button onclick="toggleorder()" class="bg-light px-3 py-2 rounded-lg">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                </svg>
            </button>
        </div>
        <aside id="order-form"
            class="bg-netral border w-5/6 lg:w-1/4 z-20 lg:z-0 fixed top-2 -right-full lg:relative lg:top-0 lg:right-0 px-4 py-4 rounded-md overflow-x-hidden h-[90vh] md:min-h-[70vh] overflow-y-scroll duration-500">
            <div class="flex flex-col gap-2">
                <div class="lg:hidden flex justify-end">
                    <button onclick="toggleorder()">
                        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <h4 class="text-lg font-bold">Total</h4>
                <p id="total" class="text-gray-600">Rp. 0</p>
                <button onclick="toggleModal('order-modal', setOrderText)"
                    class="bg-light px-3 py-1 rounded-md flex justify-center">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                    </svg>
                    Pesan
                </button>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" class="order-field border px-2 py-1 rounded"
                    placeholder="Masukan Nama Lengkap ..." value="{{ auth()->user()->name }}" required>
                <label for="nohp">No. HP</label>
                <input type="text" name="nohp" id="nohp" class="order-field border px-2 py-1 rounded"
                    placeholder="Masukan Nomor HP ..." value="{{ auth()->user()->nohp }}" required>
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" class="order-field border px-2 py-1 rounded resize-none"
                    placeholder="Masukan Alamat Lengkap ..." required></textarea>
                <label for="jaminan">Jaminan</label>
                <select name="jaminan" id="jaminan" class="order-field border px-2 py-1 rounded" required>
                    <option value="KTP">KTP</option>
                    <option value="SIM">SIM</option>
                </select>
                <label for="pengambilan">Pengambilan</label>
                <select name="pengambilan" id="pengambilan" class="order-field border px-2 py-1 rounded" required>
                    <option value="Ambil di Rumah">Ambil di Rumah</option>
                    <option value="COD">COD</option>
                </select>
                <label for="tempatcod">Tempat COD (opsional)</label>
                <textarea name="tempatcod" id="tempatcod" rows="3" class="order-field border px-2 py-1 rounded resize-none"
                    placeholder="Masukan Tempat COD ..."></textarea>
                <label for="jamambil">Jam Pengambilan</label>
                <input type="datetime-local" name="jamambil" id="jamambil" class="order-field border px-2 py-1 rounded"
                    onchange="calculateTotal()" required>
                <label for="jamkembali">Jam Pengembalian</label>
                <input type="datetime-local" name="jamkembali" id="jamkembali"
                    class="order-field border px-2 py-1 rounded" onchange="calculateTotal()" required>
            </div>
        </aside>
    </section>
    <div id="order-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('order-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 min-w-1/2 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <section class="flex justify-end mb-2">
                <button onclick="closeModal('order-modal')">
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </section>
            <div class="flex flex-col gap-2">
                <textarea id="order-text" readonly class="border rounded-md w-full resize-none p-2" rows="10"></textarea>
                <div class="flex gap-2">
                    <button onclick="copy('order-text')" class="border rounded-md px-3 py-1 flex justify-center">
                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z" />
                        </svg>
                        Copy
                    </button>
                    <button onclick="order()" class="bg-green-500 border rounded-md px-3 py-1 flex justify-center">
                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z"
                                clip-rule="evenodd" />
                            <path fill="currentColor"
                                d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z" />
                        </svg>
                        Pesan ke Whatsapp
                    </button>
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

        function copy(id) {
            document.getElementById(id).select();
            document.execCommand('copy');
            alert('Teks berhasil disalin ke clipboard');
            document.getElementById(id).blur();
        }

        function order() {
            const orderText = document.querySelector('#order-modal textarea');
            const url = `https://api.whatsapp.com/send?phone=6282257038056&text=${encodeURIComponent(orderText.value)}`;
            window.open(url, '_blank');
            closeModal('order-modal');
        }

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

        function orderTextTpl(data) {
            return `*Form Peminjaman Barang @echo.outdoor*\n\n- Nama : ${data.name}\n- No. HP : ${data.nohp}\n- Alamat : ${data.alamat}\n- Barang yang disewa : \n${data.items}\n- Jaminan : ${data.jaminan}\n- Pengambilan : ${data.pengambilan}\n- Tempat COD : ${data.tempatcod ?? '-'}\n- Jam Pengambilan : ${data.jamambil}\n- Jam Pengembalian : ${data.jamkembali}\n\nNote : Penyewaan berlaku 24 jam, lebih dari jangka waktu tersebut akan dikenakan charge 5k/jam`;
        }

        function setOrderText() {
            const orderText = document.querySelector('#order-modal textarea');
            orderText.value = '';

            const data = Array.from(document.querySelectorAll('#order-form .order-field')).reduce((acc, el) => {
                const name = el.getAttribute('name');
                const value = el.value;
                if (el.hasAttribute('required') && !value) {
                    acc.valid = false;
                }
                acc["data"][name] = value;
                return acc;
            }, {
                data: {},
                valid: true
            });

            if (!data.valid) {
                orderText.value = 'Silahkan lengkapi semua data pemesanan';
                return;
            }

            const items = orders.reduce((acc, idcart) => {
                const cart = document.querySelector(`input[value="${idcart}"]`);
                const catalog = cart.getAttribute('data-catalog');
                const catalogData = JSON.parse(catalog);
                const qty = document.getElementById('cart-qty-' + idcart).value;
                const subtotal = catalogData.price * qty;
                acc.total += subtotal;
                acc.text +=
                    `\t\t+ ${catalogData.name} (Rp. ${formatCurrency(catalogData.price)}) x ${qty} = Rp. ${formatCurrency(subtotal)}\n`;
                return acc;
            }, {
                text: "",
                total: 0
            });
            data["data"]["items"] = items.text

            if (data.data["jamambil"] && data.data["jamkembali"]) {
                const duration = new Date(data.data["jamkembali"]) - new Date(data.data["jamambil"]);
                const durationinday = Math.ceil(duration / (1000 * 60 * 60 * 24));
                data["data"]["items"] +=
                    `\t\tTotal x ${durationinday} days : Rp. ${formatCurrency(items.total * durationinday)}`
            }
            orderText.value = orderTextTpl(data["data"]);
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
            const jamambil = document.getElementById('jamambil').value;
            const jamkembali = document.getElementById('jamkembali').value;
            const durasi = (!jamambil || !jamkembali) ? 1 : (new Date(jamkembali) - new Date(jamambil));
            const durasiinday = Math.ceil(durasi / (1000 * 60 * 60 * 24));
            let total = 0;
            orders.forEach((idcart) => {
                const cart = document.querySelector(`input[value="${idcart}"]`);
                const catalog = cart.getAttribute('data-catalog');
                const catalogData = JSON.parse(catalog);
                const qty = document.getElementById('cart-qty-' + idcart).value;
                const subtotal = catalogData.price * qty * durasiinday;
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
                        alert('Gagal menghapus item dari keranjang. Coba lagi nanti.');
                    }
                });
        }
    </script>
@endsection
