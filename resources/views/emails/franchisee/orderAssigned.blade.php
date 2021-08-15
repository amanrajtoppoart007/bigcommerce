@component('mail::message')
    # नमस्ते {{ $order->assignee->name }}<br>
    आपको www.krishakvikas.com से आर्डर न. {{ $order->order_number }} सौंपा गया है|
    @component('mail::button', ['url' => route('franchisee.assigned-orders.show', $order->order_number)])
        देखें
    @endcomponent
    धन्यवाद,<br>
    {{ config('app.name') }}
@endcomponent
