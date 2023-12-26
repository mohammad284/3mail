<?php
  $lang = Session('locale');
  if ($lang != "en") {
      $lang = "ar";
  }
?>

<footer class="page-footer">
      <div class="page-footer__top">
        <div class="uk-container">
          <div class="uk-grid" data-uk-grid>
            <div class="uk-width-1-3@m uk-width-1-2@s">
              <div class="logo"><a class="logo__link" href="index.html"><img class="logo__img" src="{{ asset('frontend_res/img/logo.png')}}" alt="Doremi"></a></div>
              <p>
                  {{__('نص الفوتر')}}
              </p>
             
            </div>
            <div class="uk-width-1-3@m uk-width-1-2@s">
              <div class="uk-grid uk-grid-small uk-child-width-1-2@s" data-uk-grid>
                
                <div class="right-col">
                  <h3 class="uk-h3">{{__('الأقسام')}}</h3>
                  <ul class="uk-nav uk-nav-default">
                    @foreach ($categories as $category)
                    <li><a href="/category/{{$category->id}}">{{ $category->translate($lang)->name }}</a></li>
                    @endforeach
                  </ul>
                </div>

                <div class="left-col">
                  <h3 class="uk-h3"> {{__('المدن')}}</h3>
                  <ul class="uk-nav uk-nav-default">
                    @foreach ($cities as $city)
                    <li><a href="/city/{{$city->id}}">{{ $city->translate($lang)->name }}</a></li>
                    @endforeach
                    <li><a href="/AllCities">{{__('كل المدن')}}</a></li>
                  </ul>
                </div>
                
              </div>
            </div>
            <div class="uk-width-1-3@m uk-width-1-2@s">
            <h3 ><a class="uk-h3" href="/contact">{{__('تواصل معنا')}}</a></h3>
              
              <ul class="uk-list">
                <li> <span>{{__('البريد الالكتروني')}}:</span><a href="mailto:support@domain.com">support@domain.com</a></li>
                <li> <span>{{ __('الهاتف') }}: </span><a href=" tel:104023513690" class="phone-number-link">+1 (040) 2351 3690</a></li>
              </ul>
              <ul class="social">
                <li><a href="#!"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#!"><i class="fab fa-youtube"></i></a></li>
                <li><a href="#!"><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </footer>
  </div>
  <script src="{{ asset('frontend_res/js/jquery.min.js')}}"></script>
  <script src="{{ asset('frontend_res/js/uikit.min.js')}}"></script>
  <script src="{{ asset('frontend_res/js/owl.carousel.js')}}"></script>
  <script src="{{ asset('frontend_res/js/uikit-icons.min.js')}}"></script>
  <script src="{{ asset('frontend_res/js/main.js')}}"></script>

  
</body>

</html>