@component('mail::message')
# नमस्ते {{ $data['name'] }}

www.krishakvikas.com में आपका स्वागत है।

आप कृषक विकास फ्रेंचाइजी के रूप में सफलतापूर्वक पंजीकृत हैं।<br>
आप अब हमारे पोर्टल में किसानों का पंजीकरण शुरू कर सकते हैं, पोर्टल के लिंक और क्रेडेंशियल्स नीचे दिए गए हैं।<br>

उपयोगकर्ता नाम :- {{ $data['email'] }}<br>
पासवर्ड :- {{ $data['password'] }}<br>


@component('mail::button', ['url' => route('franchisee.login')])
    लॉगिन करें
@endcomponent

धन्यवाद,<br>
{{ config('app.name') }}
@endcomponent
