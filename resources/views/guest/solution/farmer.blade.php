@extends("guest.layout.app")
@section("content")
    <!-- Main (Start) -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light krishisamadhan-section">
            <br>
            <div class="container" align="center">

                <!-- Introduction Title (Start) -->
                <div>
                    <img src="{{ asset('assets/assets/icons/farmer.svg') }}" alt="farmer" class="img-fluid">
                    <hr class="w-50">
                    <h2 class="font-weight-bolder text-theme-1">किसान भाइयों के लिए</h2>
                    <hr class="w-50">
                    <a href="{{route('farmer.register')}}" class="btn btn-theme-1 py-2 px-4 shadow">अभी पंजीकरण करें<img
                            src="{{ asset('assets/assets/icons/circle-arrow.svg') }}" class="btn-icon" alt="arrow-right"></a>
                    <br>
                </div>
                <!-- Introduction Title (End) -->

                <!-- Tab Section (Start) -->
                <div class="card tabs-card mt-4 border-0 shadow">

                    <!-- Tabs Toggler (Start) -->
                    <div class="card-header bg-white tab" align="center">
                        <button class="tablinks" onclick="toggleTab(event, 'tab1')">मिट्टी को पहचानिये</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab2')">कृषि विज्ञान का चमत्कार</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab3')">कृषि बाज़ार</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab4')">कृषि उत्पाद मंगाइये</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab5')">कृषि परामर्श एक क्लिक में</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab6')">कृषि फाइनैंसिंग</button>
                    </div>
                    <!-- Tabs Toggler (End) -->

                    <!-- Tabs Content (Start) -->
                    <div class="card-body" align="center">

                        <div id="tab1" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">मिट्टी को पहचानिये</h5>
                            <p class="description-1 text-secondary mt-2">(मिट्टी जाँच एवं स्कोर कार्ड)</p>
                            <p class="description-2 text-dark font-weight-bolder">खेती चाहे जिस भी फसल के लिए की जाये
                                "मिटटी की जानकारी" पहला कदम है जिससे सफलता की शुरुवात होती है| मिट्टी का रासायनिक संगठन,
                                उर्वरक क्षमता। पी.एच. मान तथा पोषक तत्वों की उपलब्धता बेहतर फसल तथा उच्चतम लाभ के लिए
                                जिम्मेदार होती है |
                                हमारे उच्च तकनिकी प्रयोगशाला तथा मशीन के द्वारा हम किसान भाइयों को खेतो की सम्पूर्ण
                                जानकारी तथा स्कोर कार्ड प्रदान करते है, जिससे सम्बंधित समस्याओं का उचित निदान तथा उचित
                                फसल, बीज, खाद , दवाइयों आदि का वैज्ञानिक निर्धारण कर कृषि लागत में कमी तथा फसल में
                                बढ़ोतरी की जाती है, सभी तकनिकी मार्गदर्शन तथा ज़मीनी सहायता संस्था किसान भाइयों को प्रदान
                                करती है |</p>
                        </div>

                        <div id="tab2" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">कृषि विज्ञान का चमत्कार</h5>
                            <p class="description-1 text-secondary mt-2">(कम्प्यूटरीकृत विश्लेषण)</p>
                            <p class="description-1 text-dark font-weight-bolder">कौनसी फसल, किनता उत्पादन देगी ? कितनी
                                लागत आएगी? कितना मुनाफा होगा? हर किसान हर फसल चक्र के दौरान जानना चाहता है, लेकिन उनकी
                                पहुँच विश्वसनीय संसाधन तक नहीं है, जिसके द्वारा उनको संतोषजनक जानकारी प्राप्त हो पाए,
                                पारम्परिक तरीके सफल नहीं है क्यूंकि फसल में असर डालने वाले बहोत से कारक (मौसम, किट
                                प्रकोप, पद्धत्ति, समय आदि) है जो पूर्वानुमान को विफल कर सकते हैं,</p><br>
                            <p class="description-1 text-dark font-weight-bolder">हमारे द्वारा उच्च तकनीक तथा
                                कम्प्यूटरीकृत साधनो में रिसर्च किया जा रहा है जिसके द्वारा सभी कारको का अध्यन कर
                                पूर्वानुमान हेतु विश्लेषण प्रदान किया जायेगा तथा सही समय में सही कदम उठाये जाये जिससे की
                                फसलों की सुरक्षा और उचित उपज प्राप्त की जाये |</p>
                        </div>

                        <div id="tab3" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">कृषि बाज़ार</h5>
                            <p class="description-1 text-secondary mt-2">(उपज का ज्यादा मूल्य)</p>
                            <p class="description-1 text-dark font-weight-bolder">आज के कृषि बाजार में तरह-तरह के
                                बिचौलिए तथा दलालो का दबदबा है, जिन्होंने किसान और खरीददारों के बीच बड़ी दिवार बनाने का
                                काम किया है,
                                बहुस्तरीय हस्तांतरण एवं प्रतिस्पर्धा से किसान और खरीददारों को उचित मूल्य प्राप्ति तथा
                                पारदर्शिता का अभाव है|
                                किसान तथा खरीददारों हेतु बनाया गया एकीकृत तकनिकी पायदान, ऑनलाइन प्रसंस्करण एवं वृहद्
                                नेटवर्क के द्वारा किसानो तथा खरीददारों को पारदर्शी और लाभदायक लेन-देन करने के लिए सक्षम
                                बनाता है, किसानो को बाज़ार से सीधा संपर्क, खरीददारों के लिए विश्वसनीय सप्लाई चैन अत्यंत
                                लाभप्रद व्यापार को सुनिश्चित करता है|</p><br>
                            <p class="description-1 text-dark font-weight-bolder">शहर से गांव तक, सेवा केन्द्रो से
                                किसानो तक हमारा सीधा संपर्क, खेतो तक हमारी पहुंच तथा किसान भाइयों को सभी तकनिकी सहायता
                                और कम्प्यूटरीकृत फसल निगरानी अच्छी से अच्छी उपज प्रदान करती है, संस्था द्वारा प्रद्दत्त
                                भण्डारण एवं विपणन व्यवस्था संस्थागत खरीददारों हेतु सकारात्मक व्यावसायिक वातावरण प्रदान
                                करता है | सुव्यवस्थित प्रणाली तथा तकनिकी द्वारा किसानो को फसल हानि से बचाया जा रहा है
                                तथा उपज को अच्छे से अच्छे दामों में खरीददारों तक पहुँचाया जा रहा है जिससे २०% तक की
                                बढ़ोतरी किसान भाइयों की कमाई में देखि जा रही है |</p>
                        </div>

                        <div id="tab4" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">कृषि उत्पाद मंगाइये</h5>
                            <p class="description-1 text-secondary mt-2">(बीज, खाद, दवाइयां)</p>
                            <p class="description-1 text-dark font-weight-bolder">किसान भाइयों की सफलता में कौन सा बीज,
                                खाद, दवाइयां उपयोग में लायी जाएं यह सबसे महत्वपूर्ण कदम होता है, आज के व्यवसायीकरण में
                                किसान भाइयों को भ्रामक जानकारियां तथा उधार के चक्र में फसा कर उनका विनाश किया जा रहा है
                                | गैरज़रूरी उत्पाद एवं गलत परामर्श देकर लागत को बढ़ाया गया |</p><br>
                            <p class="description-1 text-dark font-weight-bolder">
                                खेती की शुरुवात से कृषि उत्पादों का चयन तथा उपयोगिता फसल की मात्रा तथा गुणवत्ता का
                                निर्धारण करती है, जो की सीधे तौर पर किसान भाई की कमाई तथा उन्नति का साधन बनती है,
                                मुनाफाखोरी तथा व्यवसायीकरण की होड़ में किसानो तक निचली गुणवत्ता तथा नकली दवाओं को
                                पहुँचाया जा रहा है, उधार के प्रलोभन ने बड़े बोझ से किसान भाइयों को दबाया है |</p><br>
                            <p class="description-1 text-dark font-weight-bolder">
                                हमारे मज़बूत धाराप्रवाह तकनिकी समाधान के द्वारा सभी किसान भाइयों को वैज्ञानिक मार्गदर्शन,
                                सही दवा, सही मात्रा, सही समय तथा उपयोग विधि, उचित और गुणवत्ता पूर्ण उत्पादों की सही समय
                                में उपलब्धता जो की सीधे कंपनी से किसानो तक दी जा रही है, किसान भाइयों को २० % से ज्यादा
                                की बचत करवाती है</p>
                        </div>

                        <div id="tab5" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">कृषि परामर्श एक क्लिक में</h5>
                            <p class="description-1 text-secondary mt-2">(हेल्पलाइन तथा सहायता)</p>
                            <p class="description-1 text-dark font-weight-bolder">किसान भाई पारम्परिक रूप से खेती-किसानी
                                की जानकारी अपने अनुभवों से, मित्रो, पडोसी या बुज़ुर्गों से प्राप्त करते आ रहे है, जो की
                                आज की परिस्थितियों में प्रासंगिक नहीं रह गया है, साथ ही उन्नत तकनिकी से किसान भाई बहोत
                                दूर है जिससे उनको लाभ नहीं मिल पा रहा है | </p><br>
                            <p class="description-1 text-dark font-weight-bolder">कौन सी फसल उगाई जाये? किस फसल का अच्छा
                                दाम मिलेगा? फसल किस तरीके से उगाई जाये? कब, कौनसे बीज, उर्वरक, दवाओं का प्रयोग किया जाये
                                ? आदि बहोत से सवालों ने किसान भाइयों को रोक रखा है, हमारे एकीकृत प्रणाली के द्वारा किसान
                                भाइयों को न केवल सम्बंधित जानकारी प्रदान की जा रही है अपितु सम्पूर्ण प्रशिक्षण भी प्रदान
                                किया जा रहा है, किसान भाइयो को कृषि विज्ञान की मुख्य धारा से जोड़ा गया है, अब हर ज़रूरी
                                जानकारी किसान भाइयों की उन्नति के लिए तत्पर है|</p>
                        </div>

                        <div id="tab6" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">कृषि फाइनैंसिंग</h5>
                            <p class="description-1 text-secondary mt-2">(बीमा तथा लोन)</p>
                            <p class="description-1 text-dark font-weight-bolder">कृषि के क्षेत्र में प्रकृति से बढ़कर और
                                कुछ नहीं, सभी संभव प्रयासों के बाद भी प्रकृति हमेशा कृषि पर हावी रहती है, आपदा की स्थिति
                                में किसान भाइयों को सुरक्षित रखने तथा क्षति पूर्ति के लिए फसल बिमा अनिवार्य है, हम सभी
                                बिमा कंपनियों तथा सम्बंधित संस्थानों के साथ सतत कार्यरत है ताकि किसान भाइयों को उचित
                                मूल्य में सक्षम बिमा योजनाओ से जोड़ा जा सके ताकि उन्हें निश्चिन्त होकर लगन और निष्ठा से
                                कृषि को आगे बढ़ाने का मौका मिले |</p><br>
                            <p class="description-1 text-dark font-weight-bolder">लोन : -
                                सभी किसान भाई चाहते हैं की कृषि सम्बंधित संसाधनों तक उनकी पहुंच हो, सही समय में सही
                                दामों में सभी कृषि उत्पादों की खरीदी किसान भाई कर पाएं, लेकिन बहोत से कारणों से किसान
                                भाइयो के पास आर्थिक संसाधनों की उपलब्धता समयानुसार नहीं हो पाती, इसका सीधा असर उनकी
                                फसलों में नज़र आता है और लाभांश में कमी या कृषि में नुकसान के रूप में इसका दुष्प्रभाव
                                किसान भाई झेलता है | हम सभी छोटी बड़ी लोन कंपनियों से साझेदारी कर रहे है ताकि किसान भाई
                                की इस समस्या का निदान उन्हे दिया जाये , जिससे की किसान भाई अपने खेती हेतु उपयुक्त
                                संसाधनों को योजनाबद्ध तरीके से खरीद पाए |</p>
                        </div>

                    </div>
                    <!-- Tabs Content (End) -->

                </div>
                <!-- Tab Section (End) -->

            </div>
            <br>
        </section>
        <!-- Section First (End) -->

    </main>
    <!-- Main (End) -->
@endsection
@section("script")
    <!-- Tabs Toggle Script (Start) -->
    <script type="text/javascript">
        function toggleTab(evt, tabName) {
            var i, tabContent, tablinks;
            tabContent = document.getElementsByClassName("tabContent");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            if(evt == null){
                tablinks[0].className += " active"
            }else{
                evt.currentTarget.className += " active";
            }

        }
        toggleTab(event, 'tab1');
    </script>
    <!-- Tabs Toggle Script (End) -->
@endsection
