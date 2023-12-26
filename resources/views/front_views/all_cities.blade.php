<?php
  $lang = Session('locale');
  $title = __('كل المدن');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')
    <main class="page-main">
      <div class="page-content">

      <div class="uk-container uk-margin-medium-top uk-margin-large-bottom">
          <div class="section-listing-slider uk-margin-medium">
           
              <div class="uk-position-relative" tabindex="-1" uk-slider="center: true">
                <div class="uk-slider-container">
                  <ul class="uk-slider-items uk-grid">
                    @foreach ($cities as $city)
                    <li class="uk-width-3-4">
                      <div class="listing-card">
                        <div class="listing-card__box">
                          <div class="listing-card__media shine"><a><img src="{{ asset($city->image) }}" alt="{{ $city->translate($lang)->name }}" /></a>                  
                          </div>
                        </div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  
                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
                
              </div>
           
      
          </div>
       </div>
      </div>

         <div class="section-popular uk-margin-large-bottom">
           <div class="uk-background-muted">
             <div class="uk-section-large uk-container">
              <div class="section-title uk-text-center"><span>نضع كل شيء بين يديك</span>
              <h3 class="uk-h3"> المدن</h3>
              </div>
            <div class="section-content">
              <div class="uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-medium" uk-grid>
              @foreach($cities_all as $city )
                <div class="city-item"><a class="city-item__box" href="/city/{{$city->id}}">
                  <div class="uk-cover-container uk-height-medium uk-border-rounded"><img class="city-item__img"
                      src="{{ asset($city->image) }}" alt="Paris" data-uk-cover="data-uk-cover" />
                    <div class="uk-overlay-primary uk-position-cover"></div>
                    <div class="city-item__content uk-position-bottom">
                      <div class="city-item__city">{{ $city->translate($lang)->name }}</div>
                      <div class="city-item__country"></div>
                    </div>
                    <div class="uk-position-top-right">
                      <div class="city-item__col"></div>
                    </div>
                  </div>
                </a></div>
                @endforeach
                    </div> 

                <div class="paginate-row">
                  {{ $cities_all->links() }}
                </div>
                    
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
@include('front_views.layouts.footer')   