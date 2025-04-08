@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Tipe Item</h3>
            <p class="text-sm text-justify hidden md:block">
                Master data tipe item yang digunakan untuk mengelompokkan item-item yang ada di dalam sistem.
            </p>
        </div>
        <a href="{{ route('dashboard.item-type.create') }}" class="text-sm bg-blue-500 text-white px-3 py-1 rounded-md">+ Item
            Baru</a>
    </section>
    <section class="overflow-auto w-full max-h-[62vh]">
        <table class="table-auto overflow-scroll w-[150vw] md:w-[100vw]">
            <thead>
                <tr>
                    <th class="border-b py-1 px-2 w-1">ID</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Nama</th>
                    <th class="border-b py-1 px-2 w-1">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($itemtypes as $item)
                    <tr>
                        <td class="px-2 pt-1 pb-2 text-center align-top">{{ $item->id }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->name }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('dashboard.item', ['filter_type' => $item->id]) }}"
                                    class="bg-blue-500 text-white rounded-sm px-3 py-1">Lihat Gudang</a>
                                <a href="{{ route('dashboard.item-type.edit', $item->id) }}"
                                    class="bg-blue-500 text-white rounded-sm px-3 py-1">Edit</a>
                                <a href="{{ route('dashboard.item-type.delete', $item->id) }}"
                                    class="bg-red-500 text-white rounded-sm px-3 py-1">Hapus</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($itemtypes->isEmpty())
            <div class="text-sm flex flex-col justify-center items-center gap-2 p-2">
                Tidak ada data
                <a href="{{ route('dashboard.item-type.create') }}" class="text-blue-500 underline">Tambah Item Baru</a>
            </div>
        @endif
    </section>
@endsection
