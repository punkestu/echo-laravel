@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-lg md:text-xl font-bold">Order</h3>
            <p class="hidden md:block text-sm text-justify">
                Daftar pesanan yang telah dilakukan oleh pengguna. Anda dapat melihat detail pesanan dan statusnya di sini.
            </p>
        </div>
        <a href="{{ route('dashboard.order.create') }}" class="text-sm bg-light  text-gray-800 px-3 py-1 rounded-md">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mb-2">
        <form action="{{ route('dashboard.order') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" id="search" placeholder="Cari item..."
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
    <section class="overflow-auto w-full max-h-[62vh]">
        <table class="table-auto overflow-scroll w-[400vw] md:w-[150vw]">
            <thead>
                <tr>
                    <th class="border-b py-1 px-2 w-1">ID</th>
                    <th class="border-b py-1 px-2 w-1">Status</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Nama</th>
                    <th class="border-b py-1 px-2 w-1 md:w-28 text-left">No HP</th>
                    <th class="border-b py-1 px-2 w-36 md:w-28 text-left">Alamat</th>
                    <th class="border-b py-1 px-2 w-36 md:w-28 text-left">Items</th>
                    <th class="border-b py-1 px-2 w-1">Jaminan</th>
                    <th class="border-b py-1 px-2 w-1">Pengambilan</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Tempat COD</th>
                    <th class="border-b py-1 px-2 w-10">Jam Pengambilan</th>
                    <th class="border-b py-1 px-2 w-10">Jam Pengembalian</th>
                    <th class="border-b py-1 px-2 w-1 text-right">Harga</th>
                    <th class="border-b py-1 px-2 w-1">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @php
                    $status_color = [
                        'dipesan' => 'bg-blue-500 text-white',
                        'DP' => 'bg-yellow-500',
                        'lunas' => 'bg-green-500',
                        'diproses' => 'bg-orange-500',
                        'dibawa' => 'bg-green-500',
                        'dikembalikan' => 'bg-purple-500 text-white',
                        'selesai' => 'bg-gray-500 text-white',
                        'batal' => 'bg-red-500',
                    ];

                    $status_constraint = [
                        'dipesan' => ['dipesan', 'batal'],
                        'DP' => ['DP', 'batal'],
                        'lunas' => ['lunas', 'diproses', 'batal'],
                        'diproses' => ['diproses', 'batal'],
                        'dibawa' => ['dibawa', 'selesai', 'batal'],
                        'dikembalikan' => ['dikembalikan', 'selesai', 'batal'],
                        'selesai' => ['selesai', 'batal'],
                        'batal' => ['batal'],
                    ];
                @endphp
                @foreach ($orders as $item)
                    <tr>
                        <td class="border-b py-1 px-2 w-1 text-center">
                            {{ $item->id }}
                            <input type="hidden" name="bukti_dp-{{ $item->id }}" value="{{ $item->bukti_dp }}">
                            <input type="hidden" name="bukti_lunas-{{ $item->id }}" value="{{ $item->bukti_lunas }}">
                            <input type="hidden" name="bukti_dibawa-{{ $item->id }}" value="{{ $item->bukti_dibawa }}">
                            <input type="hidden" name="bukti_kembali-{{ $item->id }}"
                                value="{{ $item->bukti_kembali }}">
                        </td>
                        <td class="border-b py-1 px-2 w-1">
                            <form id="update-status-{{ $item->id }}"
                                action="{{ route('dashboard.order.put-status', $item->id) }}" method="post"
                                class="flex justify-center">
                                @csrf
                                <select name="status" id="status"
                                    class="capitalize px-2 py-1 rounded-full border {{ $status_color[$item->status] }}"
                                    onchange="document.querySelector('#update-status-{{ $item->id }}').submit()">
                                    @foreach ($status_constraint[$item->status] as $status)
                                        <option value="{{ $status }}"
                                            {{ $item->status == $status ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="border-b py-1 px-2 w-28 text-left">{{ $item->nama }}</td>
                        <td class="border-b py-1 px-2 w-1 md:w-28 text-left">
                            <a href="https://wa.me/{{ $item->nohp_withcode() }}" target="_blank"
                                class="underline text-blue-500">
                                {{ $item->no_telp }}
                            </a>
                        </td>
                        <td class="border-b py-1 px-2 w-36 md:w-28 text-left">{{ $item->alamat }}</td>
                        <td class="border-b py-1 px-2 w-36 md:w-28 text-left">
                            <div class="flex gap-1 flex-wrap">
                                @foreach ($item->catalogs as $catalog)
                                    <span class="bg-blue-400 text-white rounded-full px-3 py-1 text-center"
                                        title="{{ $catalog->name }} x {{ $catalog->pivot->qty }}">
                                        {{ strlen($catalog->name) > 9 ? substr($catalog->name, 0, 9 - 3) . '...' : $catalog->name }}
                                        x {{ $catalog->pivot->qty }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="border-b py-1 px-2 w-1 text-center">{{ $item->jaminan }}</td>
                        <td class="border-b py-1 px-2 w-1 text-center">{{ $item->pengambilan }}</td>
                        <td class="border-b py-1 px-2 w-28">{{ $item->tempat_cod }}</td>
                        <td class="border-b py-1 px-2 w-1 text-center">{{ $item->jam_ambil }}</td>
                        <td class="border-b py-1 px-2 w-1 text-center">{{ $item->jam_kembali }}</td>
                        <td class="border-b py-1 px-2 w-1 text-right">
                            @if ($item->discount > 0)
                                <span class="line-through text-gray-400">Rp.
                                    {{ number_format($item->price, 0, ',', '.') }}
                                </span>
                            @endif
                            Rp. {{ number_format($item->theprice(), 0, ',', '.') }}
                        </td>
                        <td class="border-b py-1 px-2 w-auto">
                            <div class="flex justify-center gap-2">
                                <button onclick="toggleModal('item-list-modal', loadItemListModal({{ $item->id }}))"
                                    class="bg-blue-500 text-white rounded-sm px-3 py-1">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 9h6m-6 3h6m-6 3h6M6.996 9h.01m-.01 3h.01m-.01 3h.01M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </button>
                                <a href="{{ route('dashboard.order.edit', $item->id) }}"
                                    class="bg-light rounded-sm px-3 py-1">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                                <button
                                    onclick="toggleModal('delete-item-modal', setDeleteUrl('{{ route('dashboard.order.delete', $item->id) }}'))"
                                    class="bg-red-500 text-white rounded-sm px-3 py-1"><svg class="w-6 h-6 text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($orders->isEmpty())
            <div class="text-sm flex flex-col justify-center items-center gap-2 p-2">
                Tidak ada data
                <a href="{{ route('dashboard.order.create') }}" class="text-blue-500 underline">Tambah Item Baru</a>
            </div>
        @endif
    </section>
    <div id="delete-item-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('delete-item-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <div class="flex flex-col items-center mb-2">
                <p>Yakin ingin hapus item ini?</p>
            </div>
            <section class="flex justify-center gap-2">
                <a href="" class="bg-red-500 text-white px-3 py-1 rounded-md">Iya</a>
                <button onclick="closeModal('delete-item-modal')"
                    class="bg-blue-500 text-white px-3 py-1 rounded-md">Tidak</button>
            </section>
        </div>
    </div>
    <div id="item-list-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('item-list-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <section class="flex justify-end gap-2">
                <button onclick="closeModal('item-list-modal')">
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </section>
            <div class="flex flex-col mb-2 gap-2">
                <h4 class="font-bold">List Item</h4>
                <p>Siapkan item untuk pemesan</p>
                <div id="item-list" class="flex flex-wrap gap-2">
                    <span class="text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full">Hello
                        X 10
                    </span>
                </div>
                <div id="bukti" class="flex flex-wrap gap-2"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setDeleteUrl(url) {
            return () => {
                document.getElementById('delete-item-modal').querySelector('a').href = url;
            }
        }

        function loadItemListModal(id) {
            return async () => {
                const itemList = document.getElementById('item-list');
                itemList.innerHTML = "Loading...";
                const bukti = document.getElementById('bukti');
                const bukti_dp = document.querySelector(`input[name="bukti_dp-${id}"]`);
                if (bukti_dp.value) {
                    const span = document.createElement('span');
                    span.className =
                        'text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full';
                    span.innerHTML =
                        `<a href="/storage/${bukti_dp.value}" target="_blank" class="underline">Bukti DP</a>`;
                    bukti.appendChild(span);
                }
                const bukti_lunas = document.querySelector(`input[name="bukti_lunas-${id}"]`);
                if (bukti_lunas.value) {
                    const span = document.createElement('span');
                    span.className =
                        'text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full';
                    span.innerHTML =
                        `<a href="/storage/${bukti_lunas.value}" target="_blank" class="underline">Bukti Lunas</a>`;
                    bukti.appendChild(span);
                }
                const bukti_dibawa = document.querySelector(`input[name="bukti_dibawa-${id}"]`);
                if (bukti_dibawa.value) {
                    const span = document.createElement('span');
                    span.className =
                        'text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full';
                    span.innerHTML =
                        `<a href="/storage/${bukti_dibawa.value}" target="_blank" class="underline">Bukti Dibawa</a>`;
                    bukti.appendChild(span);
                }
                const bukti_kembali = document.querySelector(`input[name="bukti_kembali-${id}"]`);
                if (bukti_kembali.value) {
                    const span = document.createElement('span');
                    span.className =
                        'text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full';
                    span.innerHTML =
                        `<a href="/storage/${bukti_kembali.value}" target="_blank" class="underline">Bukti Kembali</a>`;
                    bukti.appendChild(span);
                }
                const url = "{{ route('api.order.items', ':id') }}".replace(':id', id);
                const auth_token = await getToken();
                fetch(url, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Authorization': `Bearer ${auth_token.token}`,
                        },
                    }).then(res => res.json())
                    .then(data => {
                        itemList.innerHTML = '';
                        data.items.forEach(item => {
                            const span = document.createElement('span');
                            span.className =
                                'text-sm bg-blue-400 text-white flex items-center gap-2 mt-2 px-3 py-1 rounded-full';
                            span.innerHTML =
                                `${item.name} X ${item.qty}`;
                            itemList.appendChild(span);
                        });
                    });
            }
        }
    </script>
@endsection
