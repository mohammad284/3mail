<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" lang=""> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Dashboard</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/bootstrap-arabic.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/normalize.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/icomoon.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/bootstrap-select.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/scrollbar.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/jquery.mmenu.all.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/prettyPhoto.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/transitions.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/main-rtl.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboardUser_res/css/responsive.css') }}">

	<!--<link rel="stylesheet" href="css/color.css">-->

	<!--<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>-->
</head>
<body class="tg-login">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!--************************************


			Mobile Menu Start
	*************************************-->
	<nav id="menu">
		<div class="menu-mobile">
			<button><i class="fa fa-close" aria-hidden="true"></i></button>
			<div class="logo-mobile">
				<a href="index.html"><img class="logo__img" src="{{ asset('frontend_res/img/logo.png') }}" alt="Doremi"></a>
			</div>
			<ul>
				<li class="menu-item-has-children">
					<a href="/">{{__('الرئيسية')}}</a>
				</li>
				<li><a href="">{{__('من نحن')}}</a></li>
				<li class="menu-item-has-children">
					<a href="#">{{__('الأقسام')}}<i class="fa fa-angle-down"></i></a>
					<ul class="sub-menu">
						@foreach ($categories as $category)
							<li><a href="03_city-listings.html">{{ $category->translate('ar')->name }}</a></li>
						@endforeach
					</ul>
				
				</li>
				<li class="menu-item-has-children">
					<a href="#">{{__('المدن')}}</a>
					<ul class="sub-menu">
						@foreach ($cities as $city)
								<li><a href="/city/{{$city->id}}">{{ $city->translate('ar')->name }}</a></li>
						@endforeach
					</ul>
				</li>
				@guest
                 @if (Route::has('login'))
				<li class="menu-item-has-children  signIn">
					<a class="sing-in" href="/login"><i class="fa fa-sign-in" aria-hidden="true"></i><span>{{__('تسجيل الدخول')}} </span></a>
					@endif
				</li>
				@if (Route::has('register'))
				<li class="menu-item-has-children  signUp">
					<a class="sing-in" href="/register"><i class="fa fa-user" aria-hidden="true"></i>{{__('انشاء حساب')}}</a>
					@endif
            		@else
				</li>

				<li class="menu-item-has-children  signUp">
					<a class="sing-in" href="/register"><i class="fa fa-user" aria-hidden="true"></i> </a>
				</li>
				<li class="menu-item-has-children  signUp">
					<a class="sing-in" href="/register"><i class="fa fa-user" aria-hidden="true"></i>{{__('انشاء حساب')}}</a>
				</li>
				@endguest
			</ul>
		</div>
	
	</nav>
	<!--************************************
			Mobile Menu End
	*************************************-->
	<!--************************************
			Wrapper Start
	*************************************-->
	<div id="tg-wrapper" class="tg-wrapper tg-haslayout">
		<!--************************************
				Header Start
		*************************************-->
		<header id="tg-header" class="tg-header tg-haslayout">
			<div class="container-fluid">
				<div class="row">
					<div class="tg-navigationarea tg-headerfixed">
						<strong class="tg-logo"><a href="index.html"><img class="logo__img" src="{{ asset('frontend_res/img/logo.png') }}" alt="company logo here"></a></strong>
					
						<nav id="tg-nav" class="tg-nav">
							<div class="navbar-header">
								<a href="#menu" class="navbar-toggle collapsed">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</a>
							</div>
							<div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
								<ul>
									<li class="menu-item-has-children">
										<a href="/">{{__('الرئيسية')}}</a>
									</li>
									<li><a href="#">{{__('من نحن')}}</a></li>
									<li class="menu-item-has-children">
										<a href="#">{{__('الأقسام')}} <i class="fa fa-angle-down"></i></a>
											<ul class="sub-menu">
											@foreach ($categories as $category)
												<li><a href="03_city-listings.html">{{ $category->translate('ar')->name }}</a></li>
											@endforeach
											</ul>
									
									</li>
									<li class="menu-item-has-children">
										<a href="#">{{__('المدن')}} <i class="fa fa-angle-down"></i></a>
										<ul class="sub-menu">
										@foreach ($cities as $city)
												<li><a href="/city/{{$city->id}}">{{ $city->translate('ar')->name }}</a></li>
										@endforeach
										</ul>
									</li>
									@guest
										@if (Route::has('login'))
										<li class="menu-item-has-children">
											<a class="sing-in" href="/login"><i class="fa fa-sign-in" aria-hidden="true"></i><span>{{__('تسجيل الدخول')}} </span></a>
										</li>
										@endif
										@if (Route::has('register'))
										<li class="menu-item-has-children">
											<a class="sing-in" href="/register"><i class="fa fa-user" aria-hidden="true"></i>{{__('انشاء حساب')}}</a>
										</li>
										@endif
										@else
										<li class="menu-item-has-children">
											<a class="sing-in" href="/dashboard"><i class="fa fa-sign-in" aria-hidden="true"></i><span> {{ Auth::user()->name }}  </span></a>
										</li>
										<li class="menu-item-has-children">
											<a class="sing-in" href="/logout"><i class="fa fa-user" aria-hidden="true"></i> {{__('تسجيل خروج')}}</a>
										</li>
									@endguest
								</ul>
							</div>
						</nav>
						
					</div>
				</div>
			</div>
		</header>
		<!--************************************
				Header End
		*************************************-->
		<!--************************************
				Inner Banner Start
		*************************************-->
		<section class="tg-parallax tg-innerbanner" data-appear-top-offset="600" data-parallax="scroll" data-image-src="{{ asset('frontend_res/img/makah.jpg') }}">
			<div class="tg-sectionspace tg-haslayout">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h1>{{__('حسابي')}}</h1>
							<ol class="tg-breadcrumb">
								<li><a href="javascript:void(0);">{{__('الرئيسية')}}</a></li>
								<li class="tg-active">{{__('اضافة مكان')}}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>