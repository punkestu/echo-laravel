@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Order Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Silahkan isi form dibawah ini untuk menambahkan order baru. Pastikan semua data yang dimasukkan sudah
                benar.
            </p>
        </div>
        <a href="{{ route('dashboard.order') }}">
            <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="member" class="block text-sm font-medium text-gray-700">Member (opsional)</label>
                <input type="text" name="member" id="member"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukan nama / no hp member" value="{{ old('member') }}">
                <input type="hidden" name="user_id">
                <div id="member-list" class="hidden bg-white mt-2 px-2 py-1 w-96 max-w-full max-h-52 overflow-y-auto">
                </div>
                @if ($errors->has('user_id'))
                    <p class="text-red-500 text-sm">{{ $errors->first('user_id') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama pemesan" value="{{ old('name') }}">
                <div id="customer-list-name"
                    class="hidden bg-white mt-2 px-2 py-1 w-96 max-w-full max-h-52 overflow-y-auto">
                </div>
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="nohp" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="nohp" id="nohp" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan no hp pemesan" value="{{ old('nohp') }}">
                <div id="customer-list-nohp"
                    class="hidden bg-white mt-2 px-2 py-1 w-96 max-w-full max-h-52 overflow-y-auto">
                </div>
                @if ($errors->has('nohp'))
                    <p class="text-red-500 text-sm">{{ $errors->first('nohp') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" rows="4" required
                    class="resize-none px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi item">{{ old('alamat') }}</textarea>
                @if ($errors->has('alamat'))
                    <p class="text-red-500 text-sm">{{ $errors->first('alamat') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="catalog" class="block text-sm font-medium text-gray-700">Item Katalog</label>
                <div id="catalog-list" class="flex gap-2">
                    @if (old('catalogs'))
                        @foreach (old('catalogs') as $key => $itemqty)
                            @php
                                $citem = $catalogs->find($itemqty['id']);
                            @endphp
                            <div class="item-order text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full"
                                data-price="{{ $citem->price }}">
                                <span>{{ $citem->name }} | Rp. {{ number_format($citem->price, 0, '.', ',') }}</span> X
                                <input type="hidden" name="catalogs[{{ $key }}][id]"
                                    value="{{ $itemqty['id'] }}">
                                <input type="number" name="catalogs[{{ $key }}][qty]"
                                    value="{{ $itemqty['qty'] }}" class="bg-white text-black px-2 py-1 w-14 rounded-md">
                                <button type="button" class="text-red-500" onclick="this.parentElement.remove()">
                                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <select id="catalog"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>Pilih katalog</option>
                    @foreach ($catalogs as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->name }} | Rp.
                            {{ number_format($item->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @if (
                    $errors->has('catalogs.*.id') ||
                        $errors->has('catalogs.*.qty') ||
                        $errors->has('catalogs') ||
                        $errors->has('catalogs.*'))
                    @php
                        $firstError = collect($errors->getMessages())
                            ->filter(function ($_, $key) {
                                return str_starts_with($key, 'catalogs');
                            })
                            ->flatten()
                            ->first();
                    @endphp
                    <p class="text-red-500 text-sm">
                        {{ $firstError }}
                @endif
            </div>
            <div class="mb-4">
                <label for="jaminan" class="block text-sm font-medium text-gray-700">Jaminan</label>
                <select id="jaminan" name="jaminan" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($jaminans as $item)
                        <option {{ old('jaminan') == $item ? 'selected' : '' }} value="{{ $item }}">
                            {{ $item }}</option>
                    @endforeach
                </select>
                @if ($errors->has('jaminan'))
                    <p class="text-red-500 text-sm">{{ $errors->first('jaminan') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="pengambilan" class="block text-sm font-medium text-gray-700">Pengambilan</label>
                <select id="pengambilan" name="pengambilan" required
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($pengambilans as $item)
                        <option {{ old('pengambilan') == $item ? 'selected' : '' }} value="{{ $item }}">
                            {{ $item }}</option>
                    @endforeach
                </select>
                @if ($errors->has('pengambilan'))
                    <p class="text-red-500 text-sm">{{ $errors->first('pengambilan') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="tempat_cod" class="block text-sm font-medium text-gray-700">Tempat COD (opsional)</label>
                <textarea name="tempat_cod" id="tempat_cod" rows="4"
                    class="resize-none px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi item">{{ old('tempat_cod') }}</textarea>
                @if ($errors->has('tempat_cod'))
                    <p class="text-red-500 text-sm">{{ $errors->first('tempat_cod') }}</p>
                @endif
            </div>
            <div class="mb-4 flex gap-4 flex-wrap">
                <aside class="flex-grow">
                    <label for="jam_ambil" class="block text-sm font-medium text-gray-700">Jam Pengambilan</label>
                    <input type="datetime-local" name="jam_ambil" id="jam_ambil"
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('jam_ambil') }}">
                    @if ($errors->has('jam_ambil'))
                        <p class="text-red-500 text-sm">{{ $errors->first('jam_ambil') }}</p>
                    @endif
                </aside>
                <aside class="flex-grow">
                    <label for="jam_kembali" class="flex-grow block text-sm font-medium text-gray-700">Jam
                        Pengembalian</label>
                    <input type="datetime-local" name="jam_kembali" id="jam_kembali"
                        class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('jam_kembali') }}">
                    @if ($errors->has('jam_kembali'))
                        <p class="text-red-500 text-sm">{{ $errors->first('jam_kembali') }}</p>
                    @endif
                </aside>
            </div>
            <div class="border p-2 rounded-md">
                <h3 class="text-sm font-bold">Total Order</h3>
                <h2 id="price" class="text-xl font-black">Rp. 0</h2>
                <input type="hidden" name="price" id="price-input">
                <button type="submit"
                    class="mt-2 bg-blue-500 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 w-full">Simpan
                    Order</button>
            </div>
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        var count = {{ old('catalogs') ? count(old('catalogs')) : 0 }};

        function setTotalPrice() {
            let totalPrice = 0;
            const items = document.querySelectorAll('.item-order');
            items.forEach(item => {
                const price = parseInt(item.dataset.price);
                const qty = parseInt(item.querySelector('input[type="number"]').value);
                if (price && qty) {
                    totalPrice += price * qty;
                }
            });
            document.querySelector('#price').innerText = "Rp. " + totalPrice.toLocaleString('id-ID');
            document.querySelector('#price-input').value = totalPrice;
        }
        setTotalPrice();

        function setItemOrderAction() {
            const items = document.querySelectorAll('.item-order');
            items.forEach(item => {
                const qtyInput = item.querySelector('input[type="number"]');
                qtyInput.addEventListener('input', function() {
                    setTotalPrice();
                });
                const qtyButton = item.querySelector('button');
                qtyButton.addEventListener('click', function() {
                    setTotalPrice();
                });
            });
        }
        setItemOrderAction();

        document.querySelector('#catalog').addEventListener('change', function(event) {
            const selectedCatalog = event.target.value;
            const selectedCatalogText = event.target.options[event.target.selectedIndex].text;
            const selectedCatalogPrice = event.target.options[event.target.selectedIndex].dataset.price;
            if (selectedCatalog == "") {
                return;
            }
            document.querySelector("#catalog-list").insertAdjacentHTML('beforeend', `
                <div class="item-order text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full" data-price="${selectedCatalogPrice}">
                    <span>${selectedCatalogText}</span>
                    <input type="hidden" name="catalogs[${count}][id]" value="${selectedCatalog}"> X
                    <input type="number" name="catalogs[${count}][qty]" class="bg-white text-black px-2 py-1 w-14 rounded-md">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">
                        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `);
            setItemOrderAction();
            setTotalPrice();
            event.target.value = "";
            count++;
        });

        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        document.querySelector('#member').addEventListener('input', function(event) {
            const query = event.target.value;
            const memberList = document.querySelector('#member-list');
            if (query.length > 2) {
                memberList.classList.remove('hidden');
                memberList.innerHTML = "Loading...";
                debounce(async () => {
                    const url = "{{ route('api.users') }}";
                    const auth_token = await getToken();
                    fetch(`${url}?search=${query}`, {
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Authorization': `Bearer ${auth_token.token}`,
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.meta.total > 0) {
                                memberList.innerHTML = "";
                                data.data.forEach(member => {
                                    memberList.insertAdjacentHTML('beforeend', `
                                <button type="button" onclick="setUserID(${member.id}, '${member.name}', '${member.nohp ?? ""}')"
                                class="p-1 hover:border w-full text-start">${member.name} | ${member.nohp ?? "-"}</button>
                                `);
                                });
                            } else {
                                memberList.innerHTML = "Tidak ada hasil";
                            }
                        });
                }, 3000)();
            } else {
                memberList.classList.add('hidden');
            }
        });

        document.querySelector('#member').addEventListener('blur', function(event) {
            setTimeout(() => {
                document.querySelector('#member-list').classList.add('hidden');
            }, 200);
        });

        document.querySelector('#member').addEventListener('focus', function(event) {
            if (event.target.value.length > 2) {
                document.querySelector('#member-list').classList.remove('hidden');
            }
        });

        document.querySelector('#name').addEventListener('input', function(event) {
            resetUserID();
            const name = event.target.value;
            const customerList = document.querySelector('#customer-list-name');
            if (name.length > 2) {
                customerList.classList.remove('hidden');
                customerList.innerHTML = "Loading...";
                debounce(async () => {
                    const url = "{{ route('api.customers') }}";
                    const auth_token = await getToken();
                    fetch(`${url}?name=${name}`, {
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Authorization': `Bearer ${auth_token.token}`,
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.meta.total > 0) {
                                customerList.innerHTML = "";
                                data.data.forEach(customer => {
                                    customerList.insertAdjacentHTML('beforeend', `
                                <button type="button" onclick="setCustomer('${customer.name}', '${customer.phone ?? ""}')"
                                class="p-1 hover:border w-full text-start">${customer.name} | ${customer.phone ?? "-"}</button>
                                `);
                                });
                            } else {
                                customerList.innerHTML = "Tidak ada hasil";
                            }
                        });
                }, 3000)();
            } else {
                customerList.classList.add('hidden');
            }
        });

        document.querySelector('#name').addEventListener('blur', function(event) {
            setTimeout(() => {
                document.querySelector('#customer-list-name').classList.add('hidden');
            }, 200);
        });

        document.querySelector('#name').addEventListener('focus', function(event) {
            if (event.target.value.length > 2) {
                document.querySelector('#customer-list-name').classList.remove('hidden');
            }
        });

        document.querySelector('#nohp').addEventListener('input', function(event) {
            resetUserID();
            const nohp = event.target.value;
            const customerList = document.querySelector('#customer-list-nohp');
            if (nohp.length > 2) {
                customerList.classList.remove('hidden');
                customerList.innerHTML = "Loading...";
                debounce(async () => {
                    const url = "{{ route('api.customers') }}";
                    const auth_token = await getToken();
                    fetch(`${url}?phone=${nohp}`, {
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Authorization': `Bearer ${auth_token.token}`,
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.meta.total > 0) {
                                customerList.innerHTML = "";
                                data.data.forEach(customer => {
                                    customerList.insertAdjacentHTML('beforeend', `
                                <button type="button" onclick="setCustomer('${customer.name}', '${customer.phone ?? ""}')"
                                class="p-1 hover:border w-full text-start">${customer.name} | ${customer.phone ?? "-"}</button>
                                `);
                                });
                            } else {
                                customerList.innerHTML = "Tidak ada hasil";
                            }
                        });
                }, 3000);
            } else {
                customerList.classList.add('hidden');
            }
        });

        document.querySelector('#nohp').addEventListener('blur', function(event) {
            setTimeout(() => {
                document.querySelector('#customer-list-nohp').classList.add('hidden');
            }, 200);
        });

        document.querySelector('#nohp').addEventListener('focus', function(event) {
            if (event.target.value.length > 2) {
                document.querySelector('#customer-list-nohp').classList.remove('hidden');
            }
        });

        function setCustomer(name, nohp) {
            document.querySelector('#customer-list-name').classList.add('hidden');
            document.querySelector('#customer-list-nohp').classList.add('hidden');

            document.querySelector('#name').value = name;
            document.querySelector('#nohp').value = nohp ?? "";
        }

        function resetUserID() {
            document.querySelector('input[name="user_id"]').value = "";
            document.querySelector('#member').value = "";
            document.querySelector('#member-list').classList.add('hidden');
        }

        function setUserID(id, name, nohp) {
            document.querySelector('input[name="user_id"]').value = id;
            document.querySelector('#member').value = name;
            document.querySelector('#member-list').classList.add('hidden');

            document.querySelector('#name').value = name;
            document.querySelector('#nohp').value = nohp ?? "";
        }
    </script>
@endsection
