@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-lg md:text-xl font-bold">Gudang</h3>
            <p class="hidden md:block text-sm text-justify">
                Daftar item yang tersedia untuk disewa. Anda dapat menambah, mengedit, dan menghapus item di sini.
            </p>
        </div>
        <a href="{{ route('dashboard.item.create') }}" class="text-sm bg-light  text-gray-800 px-3 py-1 rounded-md">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="mb-2">
        <form action="{{ route('dashboard.item') }}" method="GET" class="flex gap-2">
            <select name="filter_type" id="filter_type"
                class="text-sm border border-gray-300 rounded-md px-2 py-1 hidden md:block">
                <option value="">Semua Tipe</option>
                @foreach ($itemtypes as $itemtype)
                    <option value="{{ $itemtype->id }}" {{ request('filter_type') == $itemtype->id ? 'selected' : '' }}>
                        {{ $itemtype->name }}</option>
                @endforeach
            </select>
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
                    <th class="border-b py-1 px-2 w-28 text-left">Nama</th>
                    <th class="border-b py-1 px-2 w-1 md:w-28 text-left">Foto</th>
                    <th class="border-b py-1 px-2 w-36 md:w-28 text-left">Deskripsi</th>
                    <th class="border-b py-1 px-2 w-36">Tipe</th>
                    <th class="border-b py-1 px-2 w-1">Jumlah Total</th>
                    <th class="border-b py-1 px-2 w-28">Jumlah <br> Bagus / Rusak</th>
                    <th class="border-b py-1 px-2 w-1">Disewa</th>
                    <th class="border-b py-1 px-2 w-36 text-right">Harga Normal</th>
                    <th class="border-b py-1 px-2 w-36 text-right">Harga Sekarang</th>
                    <th class="border-b py-1 px-2 w-1">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($items as $item)
                    <tr>
                        <td class="px-2 pt-1 pb-2 text-center align-top">{{ $item->id }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->name }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <img src="{{ $item->thumb_url ? '/storage/' . $item->thumb_url : '/images/logo/normallight.svg' }}"
                                alt="Foto item" class="h-[48px]">
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top" title="{{ $item->description }}">
                            {{ strlen($item->description) > 30 ? substr($item->description, 0, 30 - 3) . '...' : $item->description }}
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <div class="flex justify-center flex-wrap gap-2">
                                @foreach ($item->itemTypes as $type)
                                    <a href="?filter_type={{ $type->id }}"
                                        class="bg-blue-400 text-white rounded-full px-3 py-1 text-center">{{ $type->name }}</a>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top text-center">{{ $item->qty }}</td>
                        <td class="px-2 pt-1 pb-2 align-top text-center">{{ $item->good_qty }} / {{ $item->bad_qty }}</td>
                        <td class="px-2 pt-1 pb-2 align-top text-center">{{ $item->rent_qty }}</td>
                        <td class="px-2 pt-1 pb-2 align-top text-right">Rp.
                            {{ number_format($item->base_price, 0, ',', '.') }}</td>
                        <td class="px-2 pt-1 pb-2 align-top text-right">Rp. {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('dashboard.item.edit', $item->id) }}"
                                    class="bg-light rounded-sm px-3 py-1">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                                <button
                                    onclick="toggleModal('delete-item-modal', setDeleteUrl('{{ route('dashboard.item.delete', $item->id) }}'))"
                                    class="bg-red-500 text-white rounded-sm px-3 py-1">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
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
        @if ($items->isEmpty())
            <div class="text-sm flex flex-col justify-center items-center gap-2 p-2">
                Tidak ada data
                <a href="{{ route('dashboard.item.create') }}" class="text-blue-500 underline">Tambah Item Baru</a>
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
@endsection
@section('scripts')
    <script>
        function setDeleteUrl(url) {
            return () => {
                document.getElementById('delete-item-modal').querySelector('a').href = url;
            }
        }
    </script>
@endsection
