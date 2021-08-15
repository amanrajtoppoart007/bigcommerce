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
                    <img src="{{ asset('assets/assets/icons/businessman.svg') }}" alt="businessman" class="img-fluid">
                    <hr class="w-50">
                    <h2 class="font-weight-bolder text-theme-1">व्यवसायी भाइयों के लिए</h2>
                    <hr class="w-50">
                    <a href="{{route('franchisee.register')}}" class="btn btn-theme-1 py-2 px-4 shadow m-2">फ्रेंचाइजी के रूप में हमसे
                        जुड़ें<img src="{{ asset('assets/assets/icons/circle-arrow.svg') }}" class="btn-icon" alt="arrow-right"></a>
                    <a href="{{route('helpCenter.register')}}" class="btn btn-theme-1 py-2 px-4 shadow m-2">सहायता केंद्र के रूप में हमसे
                        जुड़ें<img src="{{ asset('assets/assets/icons/circle-arrow.svg') }}" class="btn-icon" alt="arrow-right"></a>
                    <br>
                </div>
                <!-- Introduction Title (End) -->

                <!-- Tab Section (Start) -->
                <div class="card tabs-card mt-4 border-0 shadow">

                    <!-- Tabs Toggler (Start) -->
                    <div class="card-header bg-white tab" align="center">
                        <button class="tablinks" onclick="toggleTab(event, 'tab1')">न्यूनतम लागत (बिना दुकान)</button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab2')">तकनिकी सहायता (कृषि प्रशिक्षण)
                        </button>
                        <button class="tablinks" onclick="toggleTab(event, 'tab3')">बिज़नेस सपोर्ट (संचालन , नेटवर्क तथा
                            संवृद्धि)
                        </button>
                    </div>
                    <!-- Tabs Toggler (End) -->

                    <!-- Tabs Content (Start) -->
                    <div class="card-body" align="center">

                        <div id="tab1" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">न्यूनतम लागत (बिना दुकान) </h5>
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
                            <h5 class="font-weight-bolder text-theme-1">तकनिकी सहायता (कृषि प्रशिक्षण)</h5>
                            <p class="description-1 text-dark font-weight-bolder">कृषि क्षेत्र में कार्यरत व्यवसायी बहोत
                                सी परेशानियों का सामना करते है| व्यवसाय सम्बंधित जानकारी तथा प्रशिक्षण जैसे की तकनिकी,
                                कृषि विज्ञान, कृषि उत्पाद , कृषि यन्त्र, उन्नत पद्धत्तियाँ तथा नयी टेक्नोलॉजी आदि सभी
                                व्यवसायी बंधुओं की समस्यायों का समाधान "के.वि. प्रो - दि स्मार्ट किसान" के द्वारा एकीकृत
                                प्रणाली के द्वारा प्रदान किया जा रहा है जो की एक उत्कृष्ट कम्प्यूटरीकृत एवं मोबाइल बेस्ड
                                सोल्युशन है जो व्यवसायिय बंधुओं की ज़रूरतों को ध्यान में रखकर बनाया गया है |</p><br>
                            <p class="description-1 text-dark font-weight-bolder">के.वि. प्रो - दि स्मार्ट किसान के
                                द्वारा नए या अनुभवी सभी तरह के व्यवसायी भाइयों को सम्पूर्ण तकनिकी प्रशिक्षण प्रदान किया
                                जाता है जिससे उन्हें व्यवसाय के आधारभूत तथा नए आयामों के लिए तैयार किया जाये और किसान
                                भाइयों को उच्चतम सुविधाएं तथा मार्गदर्शन प्रदान किया जाये | ऐसे युवा बेरोज़गार जिन्हे
                                कृषि क्षेत्र में व्यवसाय करना है उन्हें संस्था विशेष प्रशिक्षण प्रदान करती है जिसके
                                द्वारा बहोत कम समय में ज़्यादा से ज़्यादा सफलता की प्राप्ति होती है |</p>
                        </div>

                        <div id="tab3" class="tabContent">
                            <h5 class="font-weight-bolder text-theme-1">बिज़नेस सपोर्ट (संचालन , नेटवर्क तथा
                                संवृद्धि)</h5>
                            <p class="description-1 text-dark font-weight-bolder">किसी भी व्यवसाय का आधार ग्राहक होते
                                है, यदि ग्राहकों का बड़ा नेटवर्क तथा उन्हें सभी संभव सुविधाएं देना आपका उद्देश्य है तो
                                "के. वि. प्रो - किसान मार्ट" आपके लिए एकमात्र संस्था है जिससे जुड़कर न केवल आप अपने
                                प्रतिस्पर्धी से कहीं आगे निकल जाते है बल्कि व्यवसाय में एकाधिकार भी प्राप्त करते है
                                |</p><br>
                            <p class="description-1 text-dark font-weight-bolder">संस्था सभी फ्रैंचाइज़ी ओनर्स को तकनिकी,
                                कृषि विज्ञानं, उत्पाद, प्रबंधन, नेतृत्व करना तथा बिज़नेस आदि का सम्पूर्ण प्रशिक्षण देती
                                है सस्था की फ्रैंचाइज़ी लेकर आप स्वयं का व्यवसाय शुरू कर सकते है और कृषक मित्र तथा किसान
                                भाइयों के बहोत बड़े नेटवर्क का संचालन कर सकते है | संस्था न केवल आपको सभी सहयता प्रदान
                                करा रही है जबकि ग्राहक भी प्रदान कर रही है |</p>
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
            if (evt == null) {
                tablinks[0].className += " active"
            } else {
                evt.currentTarget.className += " active";
            }
        }

        toggleTab(event, 'tab1');
    </script>
    <!-- Tabs Toggle Script (End) -->
@endsection
