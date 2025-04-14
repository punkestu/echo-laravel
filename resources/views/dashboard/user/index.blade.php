@extends('dashboard.layout')
@section('content')
    <section class="flex justify-between items-start flex-wrap gap-2 mb-2">
        <div>
            <h3 class="text-xl font-bold">User</h3>
            <p class="text-sm text-justify hidden md:block">
                Master data user untuk mengelola data user dan customer yang ada di dalam sistem.
            </p>
        </div>
    </section>
    <section class="mb-2">
        <form action="{{ route('dashboard.user') }}" method="GET" class="flex gap-2">
            {!! array_to_inputhidden($params, ['search']) !!}
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
        <table class="table-auto overflow-scroll w-[80vw] md:w-[90vw]">
            <thead>
                <tr>
                    <th class="border-b py-1 px-2 w-1">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'id', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center justify-center">
                            ID
                            @if ($orderBy == 'id')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="border-b py-1 px-2 w-28 text-left">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'name', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center">
                            Nama
                            @if ($orderBy == 'name')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="border-b py-1 px-2 w-28 text-left">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'email', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center">
                            Email
                            @if ($orderBy == 'email')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="border-b py-1 px-2 w-28 text-left">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'nohp', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center">
                            No HP
                            @if ($orderBy == 'nohp')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="border-b py-1 px-2 w-1">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'total_pesan', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center">
                            Total Pesan
                            @if ($orderBy == 'total_pesan')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="border-b py-1 px-2 w-1">
                        <a href="?{{ array_to_params($params, [], ['orderBy' => 'total_pengeluaran', 'desc' => $desc ? 0 : 1]) }}"
                            class="flex gap-1 items-center">
                            Total Pengeluaran
                            @if ($orderBy == 'total_pengeluaran')
                                @if (!$desc)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m17 14-5-5-5 5h10z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 10l5 5 5-5H7z" />
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($users as $item)
                    <tr>
                        <td class="px-2 pt-1 pb-2 text-center align-top">{{ $item->id }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->name }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">{{ $item->email }}</td>
                        <td class="px-2 pt-1 pb-2 align-top">
                            <a href="https://wa.me/{{ $item->nohp_withcode() }}" target="_blank"
                                class="underline text-blue-500">{{ $item->nohp }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($users->isEmpty())
            <div class="text-sm flex flex-col justify-center items-center gap-2 p-2">
                Tidak ada data
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
