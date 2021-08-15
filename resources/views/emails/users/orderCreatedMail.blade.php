@component('mail::message')
    # नमस्ते {{ $order->user->name }}<br>

    www.krishakvikas.com से आर्डर करने के लिए धन्यवाद| <br>

    आर्डर न. {{ $order->order_number }}|

    आप अपने नजदीकी सहायता केंद्र से संपर्क करके अपने आर्डर की स्तिथि पता कर सकते है|
    धन्यवाद,<br>
    {{ config('app.name') }}
@endcomponent
