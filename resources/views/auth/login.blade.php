<?php
	$title = __('تسجيل الدخول');
	  $lang = Session('locale');
  if ($lang != "en") {
      $lang = "ar";
  }
?>

@include('front_views.layouts.header')

<main id="tg-main" class="tg-main tg-sectionspace tg-haslayout">
	<div class="container">
		<div class="row">
			<div id="tg-twocolumns" class="tg-twocolumns">
				
			<form class="tg-formtheme tg-formdashboard" method="POST" action="{{ route('login') }}">
			@csrf
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
						<div id="tg-content" class="tg-content">
							<div class="tg-dashboard">
								
								
								<div class="tg-box tg-changepassword login-account">
									<div class="tg-heading text-center">
										<h3>{{__('تسجيل الدخول')}}</h3>
									</div>
									<div class="tg-dashboardcontent">
										<div class="tg-content">
											<fieldset>
												<div class="form-group">
													<label>{{__('البريد الالكتروني')}}<sup>*</sup></label>
													<input type="email" name="email" class="form-control form-control @if($errors->has('email')) error-input @endif" value="{{ old('email') }}" required  autofocus>
                            <span class="uk-text-danger"></span>
                            @if($errors->has('email')) 
            					@if ($lang == 'en')
            						<span class="invalid-feedback" role="alert">
            							Incorrect user or password
            						</span>
            					@else 
            						<span class="invalid-feedback" role="alert">
            						اسم المستخدم او كلمة المرور غير صحيحة
            						</span>
            					@endif
            				@endif
                            @if($errors->has('password')) 
            					@if ($lang == 'en')
            						<span class="invalid-feedback" role="alert">
            							Incorrect user or password
            						</span>
            					@else 
            						<span class="invalid-feedback" role="alert">
            						اسم المستخدم او كلمة المرور غير صحيحة
            						</span>
            					@endif
            				@endif
												</div>
												<div class="form-group">
													<label>{{__('كلمة المرور')}}<sup>*</sup></label>
													<input type="password" name="password" class="form-control" required >
												</div>
												<div class="remember">
													<input type="checkbox">
													<span>{{__('تذكرني')}}</span>
												</div>
												
												</div>
												<button class="tg-btn"><span>{{__('تسجيل الدخول')}}</span></button>
												<a href="{{ route('password.request') }}" class="forget">{{__('هل نسيت كلمة المرور')}}</a>
											</fieldset>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
		</div>
		
	</div>
</main>

@include('front_views.layouts.footer')