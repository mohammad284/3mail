<?php
  $lang = Session('locale');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8">
  <title>{{ $title }}</title>
  <meta content="Chernyh Mihail" name="author">
  <meta content="Ecata - City Portal" name="description">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="HandheldFriendly" content="true">
  <meta name="format-detection" content="telephone=no">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <link rel="icon" href="{{ asset('images/logo.png') }}">
  @if ($lang != "en")
  <link rel="stylesheet" href="{{ asset('frontend_res/css/bootstrap-arabic.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend_res/css/uikit-rtl.min.css') }}">
  @else
  <link rel="stylesheet" href="{{ asset('frontend_res/css/bootstrap-ltr.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend_res/css/uikit-ltr.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('frontend_res/css/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend_res/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend_res/css/boxicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend_res/css/simple-line-icons.css') }}">
  @if ($lang != "en")
  <link rel="stylesheet" href="{{ asset('frontend_res/css/style-rtl.css') }}">
  @else
  <link rel="stylesheet" href="{{ asset('frontend_res/css/style-ltr.css') }}">
  @endif
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E4Z99JD0RN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E4Z99JD0RN');
</script>
</head>

<body class="page-home">
  <div class="page-wrapper">
    <header class="page-header">
      <div class="page-header__scroll" data-uk-sticky>
        <div class="uk-container uk-container-xlarge">
          <div class="page-header__inner">
            <div class="page-header__left">
              <div class="page-header__logo logo"><a class="logo__link" href="/"><img class="logo__img" src="{{ asset('frontend_res/img/logo.png') }}" alt="3ameal"></a></div>
     
            </div>
            <!-- Menu Mobile btn -->
            <div class="mobile-btn">
              <span>
                <span></span>
                <span></span>
                <span></span>
              </span>
            </div>
            <!-- ./Menu Mobile btn -->
            <div class="page-header__right">
              <div class="page-header__mainmenu">
                <nav class="mainmenu" data-uk-navbar="">
                  <ul class="uk-navbar-nav">
                    <li><a href="/"> {{__('الرئيسية')}}</span></a> </li>
                    <li><a href="/about">  {{__('من نحن')}}</span></a> </li>
                    <li><a>{{__('الأقسام')}}<span class="uk-icon" data-uk-icon="chevron-down"></span></a>
                      <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                        @foreach ($categories as $category)
                          <li><a href="{{ url('/category/'.$category->id) }}">{{ $category->translate($lang)->name }}</a></li>
                        @endforeach
                        </ul>
                      </div>
                    </li>
                    <li><a>{{__('المدن')}}<span class="uk-icon" data-uk-icon="chevron-down"></span></a>
                      <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                          @foreach ($cities as $city)
                            <li><a href="/city/{{$city->id}}">{{ $city->translate($lang)->name }}</a></li>
                          @endforeach
                            <li><a href="/AllCities">{{__('كل المدن')}}</a></li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="/contact"> {{__('تواصل معنا')}}</span></a> 
                    </li>
                    <li>
                      @if ($lang == 'ar')
                      <a href="/en">EN</span></a> 
                      @elseif ($lang == 'en')
                      <a href="/ar">العربية</span></a> 
                      @else
                      <a href="/en">EN</span></a> 
                      @endif
                    </li>
                  </ul>
                </nav>
              </div>
              @guest
                 @if (Route::has('login'))
              <div class="page-header__sing-in"><a class="sing-in" href="/login"> <i class="fas fa-sign-in-alt"></i><span> {{__('تسجيل الدخول')}} </span></a></div>
              @endif

              @if (Route::has('register'))
              <div class="page-header__btn"><a class="sing-in" href="/register"><i class="fa fa-user" aria-hidden="true"></i> {{__('انشاء حساب')}}</a></div>
              @endif
              @else
              <div class="page-header__sing-in"><a class="sing-in" href="/dashboard"> <i class="fa fa-user"></i><span>{{ Auth::user()->name }} </span></a></div>
              <div class="page-header__btn"><a class="sing-in" href="/logout"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> {{__('تسجيل خروج')}}</a></div>

              @endguest
            </div>
            <div class="overlay-menu"><span>&times;</span></div>
          </div>
        </div>
      </div>
    </header> 
     
  