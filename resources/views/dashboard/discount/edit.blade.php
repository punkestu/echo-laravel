@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tambah Diskon Baru</h3>
            <p class="text-sm text-justify hidden md:block">
                Tambahkan diskon baru ke dalam sistem. Pastikan untuk mengisi semua informasi yang diperlukan dengan benar.
            </p>
        </div>
        <a href="{{ route('dashboard.discount') }}">
            <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mt-6">
        <form action="{{ route('dashboard.discount.update', $discount->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="member" class="block text-sm font-medium text-gray-700">Member</label>
                <input type="text" name="member" id="member"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukan nama / no hp member"
                    value="{{ old('member') ?? ($discount->user ? $discount->user->name : '') }}">
                <input type="hidden" name="user_id" value="{{ old('user_id') ?? $discount->user_id }}">
                <div id="member-list" class="hidden bg-white mt-2 px-2 py-1 w-96 max-w-full max-h-52 overflow-y-auto">
                </div>
                @if ($errors->has('user_id'))
                    <p class="text-red-500 text-sm">{{ $errors->first('user_id') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                <input type="text" name="customer" id="customer"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukan nama / no hp customer"
                    value="{{ old('customer') ?? ($discount->customer ? $discount->customer->name : '') }}">
                <input type="hidden" name="customer_id" value="{{ old('customer_id') ?? $discount->customer_id }}">
                <div id="customer-list" class="hidden bg-white mt-2 px-2 py-1 w-96 max-w-full max-h-52 overflow-y-auto">
                </div>
                @if ($errors->has('customer_id'))
                    <p class="text-red-500 text-sm">{{ $errors->first('customer_id') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="discount_amount" class="block text-sm font-medium text-gray-700">Besar Diskon</label>
                <input type="number" name="discount_amount" id="discount_amount"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan harga" value="{{ old('discount_amount') ?? $discount->discount_amount }}">
                @if ($errors->has('discount_amount'))
                    <p class="text-red-500 text-sm">{{ $errors->first('discount_amount') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Persentase Diskon</label>
                <input type="number" name="discount_percentage" id="discount_percentage"
                    class="px-2 py-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan harga" value="{{ old('discount_percentage') ?? $discount->discount_percentage }}"
                    max="100" min="0">
                @if ($errors->has('discount_percentage'))
                    <p class="text-red-500 text-sm">{{ $errors->first('discount_percentage') }}</p>
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
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function setUserID(id, name, nohp) {
            document.querySelector('input[name="user_id"]').value = id;
            document.querySelector('#member').value = name;
            document.querySelector('#member-list').classList.add('hidden');

            document.querySelector('input[name="customer_id"]').value = null;
            document.querySelector('#customer').value = "";
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
                }, 1000)();
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

        function setCustomerID(id, name, nohp) {
            document.querySelector('input[name="customer_id"]').value = id;
            document.querySelector('#customer').value = name;
            document.querySelector('#customer-list').classList.add('hidden');

            document.querySelector('input[name="user_id"]').value = null;
            document.querySelector('#member').value = "";
        }

        document.querySelector('#customer').addEventListener('input', function(event) {
            const query = event.target.value;
            const customerList = document.querySelector('#customer-list');
            if (query.length > 2) {
                customerList.classList.remove('hidden');
                customerList.innerHTML = "Loading...";
                debounce(async () => {
                    const url = "{{ route('api.customers') }}";
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
                                customerList.innerHTML = "";
                                data.data.forEach(customer => {
                                    customerList.insertAdjacentHTML('beforeend', `
                                <button type="button" onclick="setCustomerID(${customer.id}, '${customer.name}', '${customer.phone ?? ""}')"
                                class="p-1 hover:border w-full text-start">${customer.name} | ${customer.phone ?? "-"}</button>
                                `);
                                });
                            } else {
                                customerList.innerHTML = "Tidak ada hasil";
                            }
                        });
                }, 1000)();
            } else {
                customerList.classList.add('hidden');
            }
        });

        document.querySelector('#customer').addEventListener('blur', function(event) {
            setTimeout(() => {
                document.querySelector('#customer-list').classList.add('hidden');
            }, 200);
        });

        document.querySelector('#customer').addEventListener('focus', function(event) {
            if (event.target.value.length > 2) {
                document.querySelector('#customer-list').classList.remove('hidden');
            }
        });
    </script>
@endsection
