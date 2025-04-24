@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Galeri</h3>
        <p class="text-sm text-justify">
            Lihat berbagai koleksi produk yang telah kami buat
        </p>
    </section>
    <section class="flex gap-2">
        @foreach ($galleries as $gallery)
            <button class="relative flex-grow md:max-w-64"
                onclick="toggleModal('gallery-modal', setGalleryModal({image_url: '{{ $gallery->image_url }}', created_at: '{{ $gallery->created_at }}', title: '{{ $gallery->title }}', description: `{{ $gallery->description }}`}))">
                <img src="{{ asset('storage/' . $gallery->image_url) }}" alt="{{ $gallery->title }}"
                    class="rounded-lg shadow-md w-full h-64 object-contain">
                <div
                    class="absolute top-0 bg-black/50 rounded-lg w-full h-full flex justify-center items-center flex-col opacity-0 hover:opacity-100 duration-150">
                    <h4 class="text-sm font-semibold mt-2 text-white">{{ $gallery->title }}</h4>
                    <p class="text-xs text-white">{{ $gallery->created_at->format('d M Y') }}</p>
                </div>
            </button>
        @endforeach
    </section>

    <div id="gallery-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <button class="w-screen h-screen bg-black/10 absolute" onclick="closeModal('gallery-modal')"></button>
        <div class="bg-white rounded-md shadow-lg mx-4 w-96 max-h-[80vh] overflow-y-auto p-6 relative">
            <section class="flex justify-end mb-2">
                <button onclick="closeModal('gallery-modal')">
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </section>
            <div class="flex flex-col">
                <img id="gallery-image" src="" class="w-full aspect-square object-contain rounded-t-lg mb-4">
                <div class="flex justify-end">
                    <p id="gallery-date" class="text-xs"></p>
                </div>
                <h4 id="gallery-title" class="text-xl font-bold mt-2"></h4>
                <p id="gallery-description" class="text-gray-600 mt-1"></p>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setGalleryModal(data) {
            return () => {
                const image = document.getElementById('gallery-image');
                const title = document.getElementById('gallery-title');
                const description = document.getElementById('gallery-description');
                const date = document.getElementById('gallery-date');

                image.src = "/storage/" + data.image_url;
                image.setAttribute('alt', data.title);
                title.innerText = data.title;
                description.innerText = data.description;
                date.innerText = new Date(data.created_at).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        }
    </script>
@endsection
