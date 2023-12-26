
<?php
  $lang = Session('locale');
  $title = __('حجز أونلاين');
  if ($lang != "en") {
      $lang = "ar";
  }
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
                      <li><span>{{__('مطاعم')}}</span></li>
                    </ul>
                  </div>
                  <div class="section-banner__title"> {{ $item->translate($lang)->name }}</div>
               
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-content">
        <div class="uk-section-large uk-container">
          <div class="section-header">
              <h3>{{__('حجز أونلاين')}}</h3>
          </div>
          <input type="hidden" value="{{$today}}" class="today-name-input">
          <input type="hidden" value="{{ date('d') }}" class="today-day">
          <input type="hidden" value="{{ date('m') }}" class="today-month">
          <input type="hidden" value="{{ date('Y') }}" class="today-year">
          <ul style="display: none;" class="opening-days-array">
            @foreach ($worktime as $time)
            <li>
                <span class="day">{{ $time->day }}</span>
                <span class="open">{{ $time->opening_time }}</span>
                <span class="close">{{ $time->close_time }}</span>
            </li>
            @endforeach
        </ul>
          <form action="/reserveSave/{{$item->id}}" method="POST" class="reservation-form">
            @csrf
              <div class="form-group">
                  <label for="reservation-day">{{__('يوم الحجز')}}</label>
                  <ul class="reservation-days-list"></ul>
              </div>

              <div class="form-group">
                  <label for="reservation-day">{{__('عدد الأشخاص')}} </label>
                  <ul>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons" value="1">
                              <span>1</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="2">
                              <span>2</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="3">
                              <span>3</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="4">
                              <span>4</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="5">
                              <span>5</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="6">
                              <span>6</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="7">
                              <span>7</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="8">
                              <span>8</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="9">
                              <span>9</span>
                          </div>
                      </li>
                      <li>
                          <div class="single-input">
                              <input type="radio" name="reservsation_presons"  value="10">
                              <span>10</span>
                          </div>
                      </li>
                  </ul>
              </div>

              <div class="form-group">
                  <label for="reservation-day">{{__('وقت الحجز')}}</label>
                  <ul class="reservation-hours"></ul>
                                  
              </div>

              <button type="submit" class="reservation-btn">{{__('حجز')}}</button>
          </form>
        </div>
      </div>
    </main>

    @include('front_views.layouts.footer')  