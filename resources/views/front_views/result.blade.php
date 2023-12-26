@include('front_views.layouts.header')
<div class="section-blog">
        <div class="uk-section-large uk-container">
            <h3 class="uk-h3">نتائج البحث</h3>
          </div>
          <div class="section-content">
            <div data-uk-slider>
              <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                <ul class="uk-slider-items uk-grid uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m">
                @foreach ($search_item as $item)
                  <li>
                    <div class="blog-card">
                      <div class="blog-card__box">
                        <div class="blog-card__media shine">
                        @foreach ( $item->images as $img )
                    <img  src="{{ asset($img->img) }}" alt="Planet Museum" />
                    @break;
                    @endforeach
                        </div>
                        <div class="blog-card__body">
                          
                          <div class="blog-card__title"> <a href="/Place_Details/{{$item->id}}">{{ $item->translate('ar')->name }}</a></div>
                          <div class="listing-card__location"><span class="icon-location-pin"></span><span>{{ $item->translate('ar')->address }}</span></div>
                          <div class="listing-card__phone"><span class="icon-call-in"></span></span>{{ $item->phone_number }}</span></div>
                        </div>

                        <div class="listing-card__info">
                          <div class="listing-card__rating">
                            <div class="rating-box">
                              <div class="rating-box__icon">
                                <i class="fas fa-star active" aria-hidden="true"></i>
                                <i class="fa fa-star active" aria-hidden="true"></i>
                                <i class="fa fa-star active" aria-hidden="true"></i>
                                <i class="fa fa-star active" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                              </div> 
                            </div>
                          </div>
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
      @include('front_views.layouts.footer')  