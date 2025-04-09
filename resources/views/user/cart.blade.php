@extends('user.layout')
@section('content')
    <section class="mb-2">
        <h3 class="text-lg md:text-xl font-bold">Keranjang</h3>
        <p class="text-sm text-justify">
            Ayo isi keranjangmu dan segera lakukan pemesanan. Pastikan semua katalog yang kamu pilih sudah sesuai dengan
            kebutuhanmu.
        </p>
    </section>
    <section>
        @if ($carts->isEmpty())
            <div class="flex justify-center items-center h-[60vh]">
                <p class="text-lg text-gray-500">Keranjangmu kosong</p>
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach ($carts as $item)
                <button
                    onclick="toggleModal('detail-catalog-modal', setDetailCatalog({{ $item->id }}, '{{ $item->name }}', {{ $item->price }}, '{{ $item->description }}', '/storage/{{ $item->thumb_url }}', {{ $item->catalogItems }}))"
                    class="bg-white shadow-md rounded-lg p-4" title="{{ $item->description }}" popovertarget='detail-catalog'>
                    <img src="{{ $item->thumb_url ? '/storage/' . $item->thumb_url : '/images/logo/normallight.svg' }}"
                        alt="{{ $item->name }}" class="w-full h-56 object-cover rounded-t-lg">
                    <h4 class="text-xl font-bold mt-2">{{ $item->name }}</h4>
                    <p class="text-gray-600 mt-1">Rp. {{ number_format($item->price, 0, ',', '.') }} / Hari</p>
                </button>
            @endforeach
        </div>
    </section>
@endsection
@section('scripts')
@endsection
