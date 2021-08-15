@component('mail::message')
    # नमस्ते Admin<br>

    www.krishakvikas.com में किसान {{ $order->user->name }} के लिए नया आर्डर न. {{ $order->order_number }} आया है, कृपया आर्डर प्रोसेस करें|

    @component('mail::button', ['url' => route('admin.orders.show', $order->id)])
        देखें
    @endcomponent
    धन्यवाद,<br>
    {{ config('app.name') }}
@endcomponent
