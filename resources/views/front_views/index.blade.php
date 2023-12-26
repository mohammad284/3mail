<?php
  $lang = Session('locale');
  $title = __('الرئيسية');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')
  <main class="page-main">
    <div class="overlay-banner"></div>
    <div class="section-banner section-banner--home-2">
      <div class="section-banner__bg" style="background-image: url(frontend_res/img/p2.png)">
        <div class="uk-container">
          <div class="section-banner__content uk-text-center">
            <div class="section-banner__title">{{__('اكتشف معنا أروع الأماكن')}}</div>
            <div class="section-banner__text">{{__('لنطلع معاً على أفضل الأماكن للتسوق والمتعة')}}</div>
            <div class="section-banner__form">
              <form action="/search" method="get">
              @csrf
                <div class="form-search">
                  <div class="form-search__box"> 
                    <input type="search" name='search' placeholder="{{__('ابحث عن افضل الأماكن ...')}}">
                    <button class="uk-button uk-button-danger" type="submit">{{__('بحث')}}</button></div>
                </div>
              </form>
            </div>
            <div class="section-banner__bottom">
              <div class="popular-searches"><span class="uk-margin-small-right">{{__('اطلع على أشهر')}}</span>
                <ul>
                  <li><a href="{{ url('/category/31') }}" data-uk-tooltip="title: {{__('مطاعم')}}; pos: bottom"><img src="frontend_res/img/ico-popular-search-1.png" alt="popular-search"></a></li>
                  <li><a href="{{ url('/category/32') }}" data-uk-tooltip="title: {{__('فنادق')}}; pos: bottom"><img src="frontend_res/img/ico-popular-search-2.png" alt="popular-search"></a></li>
                  <li><a href="{{ url('/category/50') }}" data-uk-tooltip="title: {{__('كافيتيريات')}}; pos: bottom"><img src="frontend_res/img/ico-popular-search-3.png" alt="popular-search"></a></li>
                  <li><a href="{{ url('/category/51') }}" data-uk-tooltip="title: {{__('أسواق')}}; pos: bottom"><img src="frontend_res/img/shop.png" alt="popular-search"></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-popular">
      <div class="uk-section-large uk-container">
        <div class="section-title uk-text-center"><span>{{__('نضع كل شيء بين يديك')}}</span>
          <h3 class="uk-h3"> {{__('المدن')}} </h3>
        </div>
        <div class="section-content">
          <div class="uk-child-width-1-3@l uk-child-width-1-2@s uk-grid-medium" uk-grid>
            @foreach($cities as $city )
              <div class="city-item"><a class="city-item__box" href="/city/{{$city->id}}">
                  <div class="uk-cover-container uk-height-medium uk-border-rounded"><img class="city-item__img" src="{{ asset($city->image) }}" alt="{{ $city->translate($lang)->name }}" data-uk-cover="data-uk-cover" />
                    <div class="uk-overlay-primary uk-position-cover"></div>
                    <div class="city-item__content uk-position-bottom">
                      <div class="city-item__city">{{ $city->translate($lang)->name }}</div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div> 
        <div class="uk-first-column all-cities"><a class="uk-button uk-button-danger" href="/AllCities">{{__('كل المدن')}}</a></div>
        </div>
      </div>
    </div>
    <!-- owl slider -->
  
    <div class="section-featured">
      <div class="uk-section-large uk-container uk-container-expand">
        <div class="section-title uk-text-center"><span>{{__('اكتشف معنا الأفضل والأحدث')}}</span>
          <h3 class="uk-h3">{{__('أحدث الأماكن')}}</h3>
        </div>
        <div class="section-content">
          <div class="owl-carousel places owl-theme" id="places">
          @foreach ($items as $item)
          @if($item->item_states == 1 )
            <div class="item resturant">
              <div class="listing-card">
                <div class="listing-card__box">
                  <div class="listing-card__media shine">
                    @if ($user)
                    @php
                    $isFavourited = false;
                    @endphp
                    @if (in_array($item->id,$favourite))
                      @php
                      $isFavourited = true;
                      @endphp
                    @else
                      @php
                      $isFavourited = false;
                      @endphp
                    @endif
                    <button id="deletefavourite{{$item->id}}" 
                            onClick="deletefromFavourite({{$item->id}}, {{ Auth::user()->id }})" 
                            name="addfavourite" 
                            class="custom-favourite-btn done"
                            style="{{ $isFavourited ? '' : 'display: none;' }}">
                        <i class="fas fa-heart" ></i>
                    </button>
                    <!-- hide if favourited  ADD -->
                    <button id="addfavourites{{$item->id}}" 
                            onClick="addToFavourites({{$item->id}}, {{ Auth::user()->id }})" 
                            name="deletefavourite" 
                            class="custom-favourite-btn"
                            style="{{ $isFavourited ? 'display: none;' : '' }}">
                        <i class="fas fa-heart" ></i>
                    </button>
                    
                    @endif
                      
                      <a href="/Place_Details/{{$item->id}}">
                    @foreach ( $item->images as $img )
                    <img src="{{ asset($img->img) }}" alt="{{ $item->translate($lang)->name }}" />
                    @break;
                    @endforeach
                    
                    
                  </a>
                    
                  </div>
                  <div class="listing-card__body">
                    <div class="listing-card__title"><a href="/Place_Details/{{$item->id}}">{{ $item->translate($lang)->name }}</a></div>
                    
                    <div class="listing-card__location"><span class="icon-location-pin"></span><span>{{ $item->translate($lang)->address }}</span></div>
                    <div class="listing-card__phone"><span class="icon-call-in"></span></span>{{ $item->phone_number }}</span></div>
                  </div>
                
                  <div class="listing-card__info">
                    <div class="listing-card__rating">
                      <div class="rating-box">
                        @if (($item->rating == 0) || ($item->rating == null))
                        <span class="review-title">{{ __('لا يوجد تقييمات') }}</span>
                        @else
                        <div class="rating-box__icon">
                          <i class="fas fa-star @if($item->rating > 0) active @endif" aria-hidden="true"></i>
                          <i class="fa fa-star @if($item->rating > 1) active @endif" aria-hidden="true"></i>
                          <i class="fa fa-star @if($item->rating > 2) active @endif" aria-hidden="true"></i>
                          <i class="fa fa-star @if($item->rating > 3) active @endif" aria-hidden="true"></i>
                          <i class="fa fa-star @if($item->rating > 4) active @endif" aria-hidden="true"></i>
                        </div> 
                        @endif
                      </div>
                    </div>
                  </div>

                  </div>
                </div>
              </div>
            @endif
          @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="section-download" style="background-image: url(frontend_res/img/jadah.png);">
      <div class="overlay-download"></div>

      <div class="uk-container uk-container-large">
        <div class="section-download__box">
          <div class="section-download__content">
            <h3 class="uk-h3">{{__('قم بتنزيل التطبيق')}} </h3>
            <p>{{__('باستخدام تطبيقنا ، من الممتع اكتشاف بعض الأشياء الرائعة')}}<br> {{__('وأماكن للترفيه وتناول الطعام والتسوق والسفر')}}</p>
            <div class="">
              <div class="uk-text-center" data-uk-grid>
                  
                <div class="download-app google-play">
                  <a href="#">
                    <i class="fab fa-google-play"></i>
                    {{__('تحميل من')}}<br> Google Play
                  </a>
                </div>
                  
                <div class="download-app apple-store">
                  <a href="#">
                    <i class="fab fa-apple" aria-hidden="true"></i>
                    {{__('تحميل من')}}<br>Apple Store
                  </a>
                </div>
                
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-blog">
      <div class="uk-section-large uk-container">
        <div class="section-title uk-text-center"><span>{{__('الأماكن لابد أن تزورها لدينا')}}</span>
          <h3 class="uk-h3">{{__('الأماكن الأعلى تقييماً')}}</h3>
        </div>
        <div class="section-content">
          <div data-uk-slider>
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
              <ul class="uk-slider-items uk-grid uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m">
                @foreach ($top_rates as $top_rate)
                <li>
                  <div class="blog-card">
                    <div class="blog-card__box">
                      <div class="blog-card__media shine">
                        @if ($user)
                        @php
                        $isFavourited = false;
                        @endphp
                        @if (in_array($item->id,$favourite))
                          @php
                          $isFavourited = true;
                          @endphp
                        @else
                          @php
                          $isFavourited = false;
                          @endphp
                        @endif
                        <button id="deletefavourite{{$item->id}}" 
                                onClick="deletefromFavourite({{$item->id}}, {{ Auth::user()->id }})" 
                                name="addfavourite" 
                                class="custom-favourite-btn done"
                                style="{{ $isFavourited ? '' : 'display: none;' }}">
                            <i class="fas fa-heart" ></i>
                        </button>
                        <!-- hide if favourited  ADD -->
                        <button id="addfavourites{{$item->id}}" 
                                onClick="addToFavourites({{$item->id}}, {{ Auth::user()->id }})" 
                                name="deletefavourite" 
                                class="custom-favourite-btn"
                                style="{{ $isFavourited ? 'display: none;' : '' }}">
                            <i class="fas fa-heart" ></i>
                        </button>
                        
                        @endif
                      @foreach ( $top_rate->images as $img )
                          <a href="/Place_Details/{{$item->id}}">
                            <img src="{{ asset($img->img) }}" alt="{{__('صورة المكان')}}" />
                          </a>                              
                      @break;
                      @endforeach
                      </div>
                      <div class="blog-card__body">
                        
                        <div class="blog-card__title"> 
                          <a href="{{ url('/Place_Details/'.$item->id) }}">
                          {{ $top_rate->translate($lang)->name }}
                          </a>
                        </div>
                        <div class="blog-card__intro">
                          <p>
                              {{ $top_rate->translate($lang)->description }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
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
  
@include('front_views.layouts.footer')   