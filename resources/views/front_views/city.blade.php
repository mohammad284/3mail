<?php
  $lang = Session('locale');
  if ($lang != "en") {
      $lang = "ar";
  }
  $title = $city->translate($lang)->name;
?>
@include('front_views.layouts.header')

<main class="page-main">
  <div class="section-banner">
    
    <div class="section-banner__bg" style="background-image: url({{ asset($city->image) }})" alt="New York">  
      <div class="uk-container">
        <div class="section-banner__content uk-text-center">
          <div class="section-banner__title">{{ $city->translate($lang)->name }}</div>
          

          <div class="section-banner__info">
          
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Resturants-->
  <div class="section-featured cities cities-page">
    <div class="container">
      <div class="row">
        @if(count($categories) == 0)
        <div class="col-xs-12">
          <div class="alert alert-info" role="alert">
            {{__('لا يوجد تصنيفات حالياً لعرضها!')}}
          </div>
        </div>
        @else
        @foreach ($categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="single-category">
              <a href="{{ url('category-city/'.$category->id.'/'.$city->id) }}">
                <img src="{{ asset($category->img) }}" alt="{{ $category->translate($lang)->name }}">
                <span>{{ $category->translate($lang)->name }}</span>
              </a>
            </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </div>
</main>

@include('front_views.layouts.footer')