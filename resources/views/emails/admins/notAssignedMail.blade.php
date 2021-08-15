@component('mail::message')
    # नमस्ते, Admin <br><br>
    आर्डर नंबर {{ $order->order_number }} किसी भी फ्रेंचाइजी को असाइन नहीं हुआ है


    @component('mail::button', ['url' => route('admin.orders.show', $order)])
        देखें
    @endcomponent

    धन्यवाद,
    {{ config('app.name') }}
@endcomponent
