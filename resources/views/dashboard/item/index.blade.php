@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start mb-2">
        <div>
            <h3 class="text-xl font-bold">Gudang</h3>
            <p class="text-sm text-justify">
                Daftar item yang tersedia untuk disewa. Anda dapat menambah, mengedit, dan menghapus item di sini.
            </p>
        </div>
        <a href="{{ route('dashboard.item.create') }}" class="text-sm bg-blue-500 text-white px-3 py-1 rounded-md">+ Item
            Baru</a>
    </section>
    <section class="mb-2">
        <form action="{{ route('dashboard.item') }}" method="GET" class="flex gap-2">
            <select name="filter_type" id="filter_type" class="border border-gray-300 rounded-md px-2 py-1">
                <option value="">Semua Tipe</option>
                @foreach ($itemtypes as $itemtype)
                    <option value="{{ $itemtype->id }}" {{ request('filter_type') == $itemtype->id ? 'selected' : '' }}>
                        {{ $itemtype->name }}</option>
                @endforeach
            </select>
            <input type="text" name="search" id="search" placeholder="Cari item..."
                class="border border-gray-300 rounded-md px-2 py-1 w-full" value="{{ $search }}">
            <button type="submit" class="bg-blue-500 text-white rounded-md px-3 py-1">Cari</button>
        </form>
    </section>
    <section class="overflow-auto w-full max-h-[62vh]">
        <table class="table-auto overflow-scroll w-[100vw]">
            <thead>
                <tr>
                    <th class="border-b py-1 px-2 w-1">ID</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Nama</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Foto</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Deskripsi</th>
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
                            <img src="/storage/{{ $item->thumb_url }}" alt="Logo Echo" class="h-[48px]">
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top" title="{{ $item->description }}">
                            {{ strlen($item->description) > 30 ? substr($item->description, 0, 30 - 3) . '...' : $item->description }}
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <div class="flex justify-center flex-wrap gap-2">
                                @foreach ($item->itemTypes as $type)
                                    <a href="?filter_type={{ $type->id }}"
                                        class="bg-blue-400 text-white rounded-full px-3 py-1">{{ $type->name }}</a>
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
                                    class="bg-blue-500 text-white rounded-sm px-3 py-1">Edit</a>
                                <a href="{{ route('dashboard.item.delete', $item->id) }}"
                                    class="bg-red-500 text-white rounded-sm px-3 py-1">Hapus</a>
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
@endsection
