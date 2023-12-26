
<?php
	$title = __('حسابي');
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')
	<div id="tg-content" class="tg-content">
		<div class="tg-dashboard">
			<div class="tg-box tg-profile">
				<div class="tg-heading">
					<h3>{{__('ملفي الشخصي')}}</h3>
					<a class="tg-btnedit" href="/dashboard/MyProfile">{{__('تعديل الحساب')}}</a>
				</div>

				<div class="tg-dashboardcontent">
					<div class="account-box">
						<div class="img-box">
							<img src="{{ asset(Auth::user()->image) }}" alt="{{ Auth::user()->name }}">
							<span>{{ Auth::user()->name }}</span>
						</div>
						<ul>
							<li><span>{{__('البريد الإلكتروني')}}:</span> {{ Auth::user()->email }}</li>
							<li><span>{{__('رقم الهاتف')}}:</span> <span class="phone-number-link">{{ Auth::user()->phone_number }}</span></li>
							<li><span>{{__('الدولة')}}:</span> {{ Auth::user()->country }}</li>
							<li><span>{{__('QR كود')}}:</span> <img  src="{{ asset(Auth::user()->qrcode_image) }}" class="user-qr-code"></li>
						</ul>												
					</div>
				</div>
			</div>
		</div>
	</div>
@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')