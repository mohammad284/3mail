<?php
  $lang = Session('locale');
  $title = __('من نحن');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')

<main class="page-main">
 
    <div class="about-page">
        <div class="uk-container">
            <h3>{{ __('تعرف على عميل')}}</h3>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <img src="{{ asset('frontend_res/img/logo.png') }}" alt="3ameal">
                </div>
                <div class="col-md-9 col-sm-8 col-xs-12">
                    @if ($lang == "en")
                    <div class="about-box">
                        <p>
                            The first Saudi platform that provides the customer with special features and great discounts in the places and restaurants he visits, as the customer will record his visit every time he is in his favorite place or restaurant, and thus his package is upgraded between a new customer to silver, gold or diamond.
                            </p>
                            <p>
                                And because the customer is distinguished by the number of his frequent visits to his favorite places, he will get special offers and specials for him. 3ameal also allows his clients to know all the places and restaurants in all cities of the Kingdom to be able to communicate with service providers and benefit from the available reservation services.
                        </p>
                        <p>
                            Also 3ameal provides to service providers, the service of easy communication with their customers and sending them special offers.
                        </p>
                    </div>
                    @else
                    <div class="about-box">
                        <p>
                            أول منصه سعودية تتيح للعميل ميزات خاصه وتخفضيات رائعة في الاماكن والمطاعم التي يقوم بزيارتها، حيث أن العميل سوف يسجل زيارته لكل مره يتواجد فيها في مكانه او مطعمه المفضل، وبذلك تترقى باقته بين عميل جديد الى فضي أو ذهبي أو ألماسي.
                            </p>
                            <p>
                            ولكون العميل مميز بعدد زياراته المتكرره  لأماكنه المفضلة سوف يحصل على عروض مميزه وخاصة به. كما يتيح عميل لعملائه أيضاً معرفة جميع الأماكن والمطاعم المميزه في جميع مدن المملكة ليتمكن من التواصل مع مزودي الخدمه والاستفاده من خدمات الحجز المتاحة.
                        </p>
                        <p>
                            كما يقدم عميل لمزودي الخدمة،  خدمة التواصل السهل مع عملائهم وإرسال العروض المميزه لهم.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="img-col">
                
            </div>
            <div class="contnent-col">

            </div>

        </div>
    </div>

</main>

@include('front_views.layouts.footer')