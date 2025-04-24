@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">Galeri</h3>
            <p class="text-sm text-justify hidden md:block">
                Kamu bisa melihat semua item yang ada di galeri, dan mengeditnya sesuai kebutuhan.
            </p>
        </div>
        <a href="{{ route('dashboard.gallery.create') }}" class="text-sm bg-light text-gray-800 px-3 py-1 rounded-md">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </section>
    <section class="overflow-auto w-full max-h-[62vh]">
        <table class="table-auto overflow-scroll w-[150vw] md:w-[100vw]">
            <thead>
                <tr>
                    <th class="border-b py-1 px-2 w-1">ID</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Judul</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Deskripsi</th>
                    <th class="border-b py-1 px-2 w-28 text-left">Foto</th>
                    <th class="border-b py-1 px-2 w-1 text-left">Prioritas</th>
                    <th class="border-b py-1 px-2 w-1">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($galleries as $item)
                    <tr>
                        <td class="px-2 pt-1 pb-2 text-center align-top">{{ $item->id }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->title }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->description }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <img src="/storage/{{ $item->image_url }}" alt="{{ $item->title }}" class="h-24 ">
                        </td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->priority }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('dashboard.gallery.edit', $item->id) }}"
                                    class="bg-light rounded-sm px-3 py-1">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                                <button
                                    onclick="toggleModal('delete-item-modal', setDeleteUrl('{{ route('dashboard.gallery.delete', $item->id) }}'))"
                                    class="bg-red-500 text-white rounded-sm px-3 py-1"><svg class="w-6 h-6 text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
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
        @if ($galleries->isEmpty())
            <div class="text-sm flex flex-col justify-center items-center gap-2 p-2">
                Tidak ada data
                <a href="{{ route('dashboard.gallery.create') }}" class="text-blue-500 underline">Tambah Gambar Baru</a>
            </div>
        @endif
    </section>
    <div id="delete-item-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('delete-item-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <div class="flex flex-col items-center mb-2">
                <p>Yakin ingin hapus gambar ini?</p>
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
