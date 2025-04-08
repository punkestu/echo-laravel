@if (session('alert'))
    @php
        $alert = session('alert');
        $alert['type'] = $alert['type'] ?? 'info';
        $alert['message'] = $alert['message'] ?? 'Something went wrong';
        $alert['color'] = 'bg-blue-300/75';
        if ($alert['type'] == 'success') {
            $alert['color'] = 'bg-green-300/75';
        } elseif ($alert['type'] == 'error') {
            $alert['color'] = 'bg-red-300/75';
        }
    @endphp
    <div class="fixed top-0 right-0 m-4 rounded-md p-4 shadow-lg {{ $alert['color'] }} z-50 flex flex-col gap-1">
        <button class="text-black self-end text-xs" onclick="this.parentElement.remove()">✖</button>
        <p>{{ $alert['message'] }}</p>
    </div>
@endif
