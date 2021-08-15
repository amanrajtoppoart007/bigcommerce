@component('mail::message')
    # नमस्ते {{ $order->helpCenter->name }}<br>

    आपके एरिया में www.krishakvikas.com से किसान {{ $order->user->name }} के लिए नया आर्डर न. {{ $order->order_number }} आया है, कृपया आर्डर प्रोसेस करें|

    @component('mail::button', ['url' => route('helpCenter.orders.show', $order->order_number)])
        देखें
    @endcomponent
    धन्यवाद,<br>
    {{ config('app.name') }}
@endcomponent
