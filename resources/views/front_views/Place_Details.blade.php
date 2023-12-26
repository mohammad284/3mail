<?php
  $lang = Session('locale');
  if ($lang != "en") {
      $lang = "ar";
  }
  $title = $item->translate($lang)->name;
?>
@include('front_views.layouts.header')
    <main class="page-main">
      <div class="section-banner">
      @foreach ( $item->images as $img )
        <div class="section-banner__bg" style="background-image:  url({{ asset($img->img) }})">
        @break;
      @endforeach
          <div class="uk-container">
            <div class="section-banner__content">
              <div class="uk-grid uk-child-width-auto@m uk-flex-bottom" data-uk-grid>
                <div class="uk-width-expand@m">
                  <div class="section-banner__breadcrumb">
                    <ul class="uk-breadcrumb">
                      <li><a href="/">{{__('الرئيسية')}}</a></li>
                      <li><a href="/city/{{$city->id}}">{{ $city->translate($lang)->name }}</a></li>
                      @if (count($item_cat) > 0)
                      <li>
                        @foreach($item_cat as $cat)
                        <span>{{ $cat->translate($lang)->name }}</span>
                        @endforeach
                      </li>
                      @endif
                    </ul>
                  </div>
                  <div class="section-banner__title">{{ $item->translate($lang)->name }}</div>
               
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-content">
        <div class="uk-section-large uk-container">
          <div class="uk-grid uk-grid-medium" data-uk-grid>
            <div class="uk-width-2-3@m">
              <div class="section-city-place">
                <div class="uk-h3"><span class="icon-picture"></span>{{__('معرض الصور')}} </div>
                <div data-uk-slideshow="min-height: 300; max-height: 430">
                  <div class="uk-position-relative">
                  
                    <ul class="uk-slideshow-items uk-child-width-1-1" data-uk-lightbox="animation: scale">
                    @foreach ( $item->images as $img )
                      <li class="uk-border-rounded"><a href="{{ asset($img->img) }}"><img class="uk-width-1-1" src="{{ asset($img->img) }}" alt="img-gallery" data-uk-cover></a></li>
                      @endforeach
                    </ul><a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a><a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
                  </div>
                  <div class="uk-margin-top" data-uk-slider>
                    <ul class="uk-thumbnav uk-slider-items uk-grid uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ( $item->images as $img )
                    <li data-uk-slideshow-item="{{ $i }}"><a href="#"><img class="uk-border-rounded" src="{{ asset($img->img) }}" alt="img-gallery"></a></li>
                      @php
                      $i++;
                      @endphp
                    @endforeach
                   </ul>
                    
                    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-top"></ul>
                  </div>
                </div>
              </div>
              <hr class="uk-margin-large">
              <div class="section-city-place">
                <div class="uk-h3"><span class="icon-folder"></span>{{__('وصف مختصر')}} </div>
                {{ $item->translate($lang)->description }}

                 </div>

              <hr class="uk-margin-large">
              <div class="section-city-place">
                <div class="uk-h3"><span class="icon-map"></span>{{__('الموقع على الخريطة')}}</div>
                <div> <div id="map" class="uk-width-1-1 uk-height-large uk-border-rounded"></div></div>
              </div>
              <hr class="uk-margin-large">
              
              @if (($item->address != null) || ($item->phone_number != null))
              <div class="section-city-place">
                <div class="uk-h3"><span class="icon-earphones-alt"></span> {{__('معلومات للتواصل')}}</div>
                <ul class="contact-list">
                  @if ($item->address != null)
                  <li>
                    <div class="contact-item">
                      <div class="contact-item__icon icon-location-pin"></div>
                      <div class="contact-item__value">{{$item->address}} </div>
                    </div>
                  </li>
                  @endif
                  @if ($item->phone_number != null)
                  <li>
                    <div class="contact-item">
                      <div class="contact-item__icon icon-screen-smartphone"></div>
                      <div class="contact-item__value phone-number-link">{{$item->phone_number}} </div>
                    </div>
                  </li>
                  @endif

                </ul>
              </div>
              @endif
              @if (count($res) > 0)
              <hr class="uk-margin-large">
              <div class="section-city-place">
                <div class="uk-flex-middle uk-margin-medium-bottom" data-uk-grid>
                  <div class="uk-width-expand@m">
                    <h3 class="uk-h3"><span class="icon-star icon-accent"></span>{{__('التقييمات')}}</h3>
                  </div>
                </div>
                @foreach ($res as $clients_review)
                <div class="uk-comment">
                  <div class="uk-comment-header">
                    <div class="uk-grid-medium uk-flex-middle" data-uk-grid>
                      <div class="uk-width-auto"><img class="uk-comment-avatar" src="{{ asset($clients_review['user']->image) }}" width="60" height="60" alt="avatar"></div>
                      <div class="uk-width-expand">
                        <div data-uk-grid>
                          <div>
                            <h4 class="uk-comment-title uk-margin-small-bottom">{{$clients_review['user']->name}}</h4>
                          </div>
                          <div>
                            <ul class="stars-list">
                              <li><i class="fas fa-star active"></i></li>
                              <li><span>({{$clients_review['review']->client_evaluation}}/5)</span></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="uk-comment-body">
                    <p>{{$clients_review['review']->review}}</p>
                  </div>
                </div>
                @endforeach
              </div>
              @endif  
            </div>
            <div class="uk-width-1-3@m">
              <aside class="sidebar">
                @if ($user)
                    @php
                    $isFavourited = false;
                    @endphp
                    @if (count($favourite) > 0)
                      @php
                      $isFavourited = true;
                      @endphp
                    @else
                      @php
                      $isFavourited = false;
                      @endphp
                    @endif
           @guest
                @if (Route::has('login'))
                    @endif
                    @else
                <button id="deletefavourite{{$item->id}}" 
                        onClick="deletefromFavourite({{$item->id}}, {{ Auth::user()->id }})" 
                        name="addfavourite" 
                        class="btn btn-lg favourite-btn"
                        style="{{ $isFavourited ? '' : 'display: none;' }}">
                    <i class="fas fa-heart-broken"></i>
                    {{__('إزالة من المفضلة')}}
                </button>
                <!-- hide if favourited  ADD -->
                <button id="addfavourites{{$item->id}}" 
                        onClick="addToFavourites({{$item->id}}, {{ Auth::user()->id }})" 
                        name="deletefavourite" 
                        class="btn btn-lg favourite-btn"
                        style="{{ $isFavourited ? 'display: none;' : '' }}">
                    <i class="fas fa-heart" ></i>
                    {{__('إضافة إلى المفضلة')}}
                </button>
            @endguest
                @endif

                @if (($item->whatsapp_phone != null) || ($item->phone_number != null))
                <div class="widjet widjet-form">
                  <h4 class="widjet__title">{{__('الحجز عبر الإنترنت')}}</h4>
                    <!-- Hidden Required Fields -->

                    <!-- END Hidden Required Fields -->
                      @if($item->phone_number != null)
                      <div class="contact-item">
                        <div class="contact-item__icon icon-call-in"></div>
                        <div class="contact-item__value phone-number-link">
                          <a href="tel:{{$item->phone_number}}" target="_blank">
                            {{$item->phone_number}} 
                          </a>
                        </div>
                      </div>
                      @endif
                      @if($item->whatsapp_phone != null)
                      <div class="contact-item">
                        <div class="contact-item__icon icon-screen-smartphone"></div>
                        <div class="contact-item__value phone-number-link">
                          <a href="https://wa.me/{{$item_whatsapp}}" target="_blank">
                            {{$item->whatsapp_phone}}
                          </a>  
                        </div>
                      </div>
                      @endif
                      @if ($user)
                        @guest
                        @if (Route::has('login'))
                        @endif
                        @else
                        @if (count($workTime)> 0)
                        <!--
                      <div class="uk-margin-small">
                        <a class="uk-button uk-button-danger uk-width-1-1" href="{{ url('reserve/'.$item->id) }}">
                        {{__('حجز أونلاين')}}
                        </a>
                      </div>
                      -->
                      @endif
                      @endguest
                      @endif
                    <div class="uk-margin-small-top uk-text-center">
                      
                    </div>
                </div>
                <!--
                @endif
                @if (count($workTime)> 0)
                <div class="widjet widjet-time-work">
                  <h4 class="widjet__title">{{__('أوقات العمل')}}</h4>
                  <ul class="time-work-list">
                    @foreach($workTime as $time)
                      @switch($time->day )
                          @case('saturday')
                          <li>
                            <span class="day">{{__('السبت')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'sunday')
                          <li>
                            <span class="day">{{__('الأحد')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'monday')
                          <li>
                            <span class="day">{{__('الإثنين')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'tuesday')
                          <li>
                            <span class="day">{{__('الثلاثاء')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'wednesday')
                          <li>
                            <span class="day">{{__('الأربعاء')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'thursday')
                          <li>
                            <span class="day">{{__('الخميس')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                          @case( 'friday')
                          <li>
                            <span class="day">{{__('الجمعة')}}</span> 
                            <span class="start">{{ $time->opening_time }}</span> 
                            <span class="arrow-space">==></span>  
                            <span class="start">{{ $time->close_time }}</span>
                          </li>
                          @break
                      @endswitch
                    @endforeach
                  </ul>
                </div>
                @endif
                -->
              </aside>
                
               
            </div>
          </div>
        </div>
      </div>
    </main>


  <script>
    function addToFavourites(itemid, userid) {
      var user_id = userid;
      var item_id = itemid;
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'post',
          url: '/addToFavourite',
          data: {
              'user_id': user_id,
              'item_id': item_id,
          },
          success: function () {
              // hide add button
              $('#addfavourites' + item_id).hide();
              // show delete button
              $('#deletefavourite' + item_id).show();
          },
          error: function (XMLHttpRequest) {
              // handle error
          }
      });

    }
    function deletefromFavourite(itemid, userid) {
      var user_id = userid;
      var item_id = itemid;
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'post',
          url: '/deletefromFavourite',
          data: {
              'user_id': user_id,
              'item_id': item_id,
          },
          success: function () {
              // hide delete button
              $('#deletefavourite' + item_id).hide();
              // show add button
              $('#addfavourites' + item_id).show();
              
          },
          error: function (XMLHttpRequest) {
              // handle error
          }
      });

    }
  </script>

    <script>
        function initMap() {
          // The location of Uluru
          const uluru = { lat: {{$item->latitude}} , lng: {{$item->longitude}} };
          // The map, centered at Uluru
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: uluru,
          });
          // The marker, positioned at Uluru
          const marker = new google.maps.Marker({
            position: uluru,
            map: map,
          });
        }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo&callback=initMap&libraries=&v=weekly&channel=2"
      async
    ></script>
    @include('front_views.layouts.footer')  